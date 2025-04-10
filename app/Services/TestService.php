<?php

namespace App\Services;

use App\Models\TestAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestService
{
    public function validateTest(Request $request): bool
    {
        if (!preg_match("/^[А-Яа-яёЁ]+\s[А-Яа-яёЁ]+\s[А-Яа-яёЁ]+$/u", $request->name)) {
            return false;
        }

        $this->createTestAnswers($request);

        return true;
    }

    public function createTestAnswers(Request $request): void
    {
        $answer = new TestAnswer();
        $answer->user_id = Auth::id();
        $answer->data = json_encode([
            'elementEcosystem' => [$request->elementEcosystem, $request->elementEcosystem == 4],
            'eating' => [$request->eating, in_array($request->eating, ["Человек", "человек"])],
            'wolf' => [$request->wolf, $request->wolf === true],
            'rabbit' => [$request->rabbit, $request->rabbit === false],
            'bear' => [$request->bear, $request->bear === true],
        ]);
        $answer->save();
    }
}
