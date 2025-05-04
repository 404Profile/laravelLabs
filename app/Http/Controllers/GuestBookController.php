<?php

namespace App\Http\Controllers;

use App\Models\GuestBook;
use App\Services\GuestBookFileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Inertia\Inertia;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class GuestBookController extends Controller
{
    protected $guestBookService;

    public function __construct(GuestBookFileService $guestBookService)
    {
        $this->guestBookService = $guestBookService;
    }

    public function index()
    {
        $guestBooks = $this->guestBookService->getPaginatedMessages(10);

        return Inertia::render('GuestBook', [
            'guestBooks' => $guestBooks,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'author_name' => 'nullable|string|max:255',
        ]);

        $this->guestBookService->addMessage(
            $validated['title'],
            $validated['content'],
            $validated['author_name'] ?? null
        );

        return redirect()->back()->with('success', 'Запись добавлена успешно!');
    }

    public function destroy($id)
    {
        $this->guestBookService->deleteMessage($id);

        return redirect()->route('guest-book.index')->with('success', 'Запись удалена');
    }

    public function export()
    {
        $spreadsheet = $this->guestBookService->exportToExcel();

        $writer = new Xlsx($spreadsheet);
        $filename = 'guest_book_' . date('Y-m-d') . '.xlsx';

        $tempFile = tempnam(sys_get_temp_dir(), 'excel_');
        $writer->save($tempFile);

        return Response::download($tempFile, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ])->deleteFileAfterSend(true);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls|max:2048',
        ]);

        $file = $request->file('file');
        $spreadsheet = IOFactory::load($file->getPathname());
        $worksheet = $spreadsheet->getActiveSheet();

        $rows = $worksheet->toArray();

        array_shift($rows);

        $imported = $this->guestBookService->importFromExcel($rows);

        return redirect()->route('guest-book.index')
            ->with('success', "Успешно импортировано {$imported} записей");
    }

}
