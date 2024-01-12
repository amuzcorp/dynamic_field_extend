<?php
namespace Amuz\XePlugin\DynamicFieldExtend\Controller;

use Illuminate\Support\Facades\Response;
use Overcode\XePlugin\DynamicFactory\Models\CptDocument;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use View;
use Auth;
use XeTheme;
use XeFrontend;
use XePresenter;
use App\Http\Controllers\Controller as BaseController;
use Xpressengine\Http\Request;

class Controller extends BaseController
{
    public function question_excel_download($doc_id) {
        $cpt_doc = CptDocument::division('lg_questionnaire')->where('id', $doc_id)->first();

        //문진표에 문제가 등록되지 않았을 경우 에러 메시지 출력
        if($cpt_doc->questions_columns == '' || !$cpt_doc->questions_columns) return redirect()->back()->with('alert', [
            'type' => 'danger',
            'message' => '문항이 등록된 문진표가 아닙니다.'
        ]);

        $result_table = 'field_dynamic_field_extend_adapfit_question_result';
        $searchTargetQuestion = \XeDB::table($result_table)->where('doc_id', $cpt_doc->id)->where('group', 'documents_adapfit_license_application')->get();

        //조회된 답변 리스트가 0일 경우 에러메시지 출력
        if(count($searchTargetQuestion) <= 0) return redirect()->back()->with('alert', [
            'type' => 'danger',
            'message' => '문항에 답변한 회원이 없습니다.'
        ]);

        $joinQuestionList = CptDocument::whereIn('id', $searchTargetQuestion->pluck('target_id'))->get();

        $qeustions = json_dec($cpt_doc->questions_columns);

        $formOrder = [
            [40,'doc_id'],
            [30,'writer'],
            [30,'write_date']
        ];
        $excels[] = [
            'doc_id' => '문서 ID',
            'writer' => '작성자',
            'write_date' => '작성일'
        ];

        $index = 1;
        foreach($qeustions as $question) {
            $formOrder[] = [60, 'question' . $index];
            $excels[0]['question' . $index] = $question->title;
            $index++;
        }
        $answer = 0;
        foreach($searchTargetQuestion as $questionResult) {
            if($questionResult->result === '' || $questionResult->result === null) continue;

            $target = $joinQuestionList->where('id', $questionResult->target_id)->first();
            if(!$target) continue;

            $result = json_dec($questionResult->result);
            if(!isset($result->answer) || $result->answer !== true) continue;

            $formData = [
                'doc_id' => $target->id,
                'writer' => $target->writer,
                'write_date' => $questionResult->update_date
            ];

            $index = 1;
            foreach($result->result as $val) {
                if($val->check_type == 1 && $val->question_type == 1) {
                    $formData['question'.$index] = (string) $val->selected;
                } else if($val->check_type == 2 && $val->question_type == 1) {
                    $select = '';
                    $check_index = 1;
                    foreach($val->checked as $check) {
                        if($check) {
                            if($select == '') {
                                $select = $select.$check_index;
                            } else {
                                $select = $select.','.$check_index;
                            }
                        }
                        $check_index++;
                    }
                    $formData['question'.$index] = $select;
                } else if($val->question_type == 2) {
                    $formData['question'.$index] = $val->text;
                }
                $index++;
            }

            $excels[] = $formData;
            $answer++;
        }

        //답변 Count 가 0일경우 에러 출력
        if($answer === 0) return redirect()->back()->with('alert', [
            'type' => 'danger',
            'message' => '문항에 답변한 회원이 없습니다.'
        ]);

        $callback = function () use ($formOrder, $excels) {
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $alpha = range('A', 'Z');
            foreach($formOrder as $i => $val){
                $cellName = $alpha[$i].'1';
                $sheet->getColumnDimension($alpha[$i])->setWidth($val[0]);
                $sheet->getRowDimension('1')->setRowHeight(25);
                $sheet->setCellValue($cellName, (string) $val[1]);
                $sheet->getStyle($cellName)->getFont()->setBold(true);
                $sheet->getStyle($cellName)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle($cellName)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            }

            for ($i = 2; $row = array_shift($excels); $i++) {
                foreach ($formOrder as $key => $val) {
                    $cellName = $alpha[$key].$i;
                    $sheet->setCellValue($cellName, (string) $row[$val[1]]);
                }
            }

            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            $writer->save('php://output');
//            dd($writer);
        };
//        $callback();

        $filename = $cpt_doc->title .' 결과';
        $headers = array(
            "Content-type" => "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
            "Content-Disposition" => 'attachment; filename=' . $filename . '.xlsx',
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );
//        dd($headers, $callback);

        return Response::stream($callback, 200, $headers);
//        return [$headers, $callback];
    }

    public function CallDocumentList(Request $request) {
        $cpt_id = $request->get('instance_id');
        $page = $request->get('page') ?: 1;

        $getDocumentListIds = \XeDB::table('documents')->where('instance_id', $cpt_id)->pluck('id');
        $documentList = CptDocument::division($cpt_id)->whereIn('id', $getDocumentListIds)->orderBy('created_at', 'DESC')->
        paginate(10, ['*'], 'page', $page);

        return XePresenter::makeApi(['error' => 0, 'message' => 'Complete', 'data' => $documentList]);
    }

    public function CallQuestionField(Request $request) {
        $cpt_id = $request->get('instance_id');
        $doc_id = $request->get('doc_id');
        $question_field = $request->get('question_field');
        $documentData = CptDocument::division($cpt_id)->where('id', $doc_id)->where('instance_id', $cpt_id)->first();
        $documentData = (array) $documentData->getAttributes();

        if(!$documentData[$question_field]) return XePresenter::makeApi(['error' => -1, 'message' => '문제가 없습니다']);

        $question = json_dec($documentData[$question_field]);

        return XePresenter::makeApi(['error' => 0, 'message' => 'Complete', 'data' => $question]);
    }
}
