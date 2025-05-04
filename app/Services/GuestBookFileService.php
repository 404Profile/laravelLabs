<?php

namespace App\Services;

use App\Models\GuestBook;
use Carbon\Carbon;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class GuestBookFileService
{
    const MESSAGES_FILE = 'storage/app/guestbook/messages.inc';

    public function getAllMessages()
    {
        if (!file_exists(self::MESSAGES_FILE)) {
            $this->createMessagesFile();
            return [];
        }

        $data = include self::MESSAGES_FILE;
        return is_array($data) ? $data : [];
    }

    public function getPaginatedMessages($perPage = 10)
    {
        $messages = $this->getAllMessages();

        $page = request()->get('page', 1);
        $offset = ($page - 1) * $perPage;

        $items = array_slice($messages, $offset, $perPage);
        $total = count($messages);

        $paginator = new \stdClass();
        $paginator->data = $items;
        $paginator->current_page = $page;
        $paginator->per_page = $perPage;
        $paginator->total = $total;
        $paginator->last_page = ceil($total / $perPage);

        return $paginator;
    }

    public function addMessage($title, $content, $author_name = null)
    {
        $messages = $this->getAllMessages();

        $newMessage = [
            'id' => count($messages) > 0 ? max(array_column($messages, 'id')) + 1 : 1,
            'title' => $title,
            'content' => $content,
            'author_name' => $author_name,
            'created_at' => Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon::now()->toDateTimeString(),
        ];

        $messages[] = $newMessage;

        $this->saveMessagesFile($messages);

        return $newMessage;
    }

    public function deleteMessage($id)
    {
        $messages = $this->getAllMessages();

        $filteredMessages = array_filter($messages, function($message) use ($id) {
            return $message['id'] != $id;
        });

        $this->saveMessagesFile(array_values($filteredMessages));

        return true;
    }

    private function createMessagesFile()
    {
        if (!is_dir(dirname(self::MESSAGES_FILE))) {
            mkdir(dirname(self::MESSAGES_FILE), 0755, true);
        }

        $this->saveMessagesFile([]);
    }

    private function saveMessagesFile($messages)
    {
        $content = "<?php\n\nreturn " . var_export($messages, true) . ";\n";
        file_put_contents(self::MESSAGES_FILE, $content);
    }


    public function exportToExcel(): Spreadsheet
    {
        $messages = $this->getAllMessages();

        usort($messages, function($a, $b) {
            return strtotime($b['created_at']) - strtotime($a['created_at']);
        });

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Заголовок');
        $sheet->setCellValue('C1', 'Содержание');
        $sheet->setCellValue('D1', 'Автор');
        $sheet->setCellValue('E1', 'Создано');

        $row = 2;
        foreach ($messages as $message) {
            $sheet->setCellValue('A' . $row, $message['id']);
            $sheet->setCellValue('B' . $row, $message['title']);
            $sheet->setCellValue('C' . $row, $message['content']);
            $sheet->setCellValue('D' . $row, $message['author_name'] ?? 'Гость');

            $createdAt = Carbon::parse($message['created_at'])->format('d.m.Y H:i:s');
            $sheet->setCellValue('E' . $row, $createdAt);

            $row++;
        }

        foreach (range('A', 'E') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        $sheet->getStyle('A1:E1')->getFont()->setBold(true);
        $sheet->getStyle('A1:E1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('EEEEEE');

        return $spreadsheet;
    }

    public function importFromExcel(array $rows): int
    {
        $messages = $this->getAllMessages();
        $lastId = count($messages) > 0 ? max(array_column($messages, 'id')) : 0;
        $importCount = 0;

        foreach ($rows as $row) {
            if (!empty($row[1]) && !empty($row[2])) {
                $lastId++;
                $messages[] = [
                    'id' => $lastId,
                    'title' => $row[1],
                    'content' => $row[2],
                    'author_name' => $row[3] ?? null,
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'updated_at' => Carbon::now()->toDateTimeString(),
                ];
                $importCount++;
            }
        }

        $this->saveMessagesFile($messages);

        return $importCount;
    }
}
