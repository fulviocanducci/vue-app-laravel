<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Form;
use Illuminate\Http\Request;

class FormsController extends Controller
{
    protected $form;
    public function __construct(Form $form)
    {
        $this->form = $form;
    }

    public function index()
    {
        return $this->form->with(['items', 'items.answers'])->get();
    }

    public function create(Request $request)
    {
        $data = $request->only(['question', 'status']);
        $form = $this->form->create($data);
        if ($form) {
            $items = $request->get('items');
            foreach ($items as $item) {
                if ((bool)$item['status']) {
                    $formItem = $form->items()->create([
                        'name' => $item['name'],
                        'type' => $item['type'],
                        'status' => $item['status']
                    ]);
                    foreach ($item['answers'] as $asnwer) {
                        if ((bool)$asnwer['status']) {
                            $formItem->answers()->create([
                                'text' => $asnwer['text'],
                                'status' => $asnwer['status']
                            ]);
                        }
                    }
                }
            }
        }
        $form->load('items');
        $form->load('items.answers');
        return response()->json($form, 201);
    }

    public function edit(Request $request, $id)
    {
        $dataForm = $request->only(['question', 'status']);
        $form = $this->form->find((int)$id);
        if ($form) {
            $form->fill($dataForm);
            $form->save();
            $items = $request->get('items');
            foreach ($items as $item) {
                if (!((bool)$item['status'])) {
                    $itemDelete = $form->items()->where('id', $item['id'])->first();
                    if ($itemDelete) {
                        $itemDelete->answers()->delete();
                        $itemDelete->delete();
                    }
                } else {
                    $dataItem = [
                        'name' => $item['name'],
                        'type' => $item['type'],
                        'status' => $item['status']
                    ];
                    $formItem = $form->items()->where('id', $item['id'])->first();
                    if ($formItem) {
                        $formItem->fill($dataItem);
                        $formItem->save();
                    } else {
                        $formItem = $form->items()->create($dataItem);
                    }
                    foreach ($item['answers'] as $asnwer) {
                        if (!((bool)$asnwer['status'])) {
                            $formItemsAnswers = $formItem->answers()->where('id', $asnwer['id'])->first();
                            if ($formItemsAnswers) {
                                $formItemsAnswers->delete();
                            }
                        } else {
                            $dataAnswers = [
                                'text' => $asnwer['text'],
                                'status' => $asnwer['status']
                            ];
                            $formItemsAnswers = $formItem->answers()->where('id', $asnwer['id'])->first();
                            if ($formItemsAnswers) {
                                $formItemsAnswers->fill($dataAnswers);
                                $formItemsAnswers->save();
                            } else {
                                $formItem->answers()->create($dataAnswers);
                            }
                        }
                    }
                }
            }
        }
        return response()->noContent(204);
    }

    public function show($id)
    {
        return $this->form->with(['items', 'items.answers'])
            ->where('id', $id)
            ->first();
    }

    public function delete($id)
    {
        return $id;
    }
}
