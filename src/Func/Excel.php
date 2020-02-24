<?php

namespace Lexin\Func;

class Excel
{
    /**
     * 讀取excel文件內的完整內容，加載為數據返回
     * @param     $filePath
     * @param int $sheetNum
     * @return array
     * @throws \PHPExcel_Exception
     * @throws \PHPExcel_Reader_Exception
     */
    public static function read_excel($filePath, $sheetNum = 0)
    {
        if (!is_file($filePath)) {
            return [];
        }

        $inputFileType = \PHPExcel_IOFactory::identify($filePath);
        $PHPReader     = \PHPExcel_IOFactory::createReader($inputFileType);
        //只讀去數據，忽略裡面各種格式等(對於Excel讀取，有很大優化)
        // $PHPReader->setReadDataOnly(true);

        $PHPExcel = $PHPReader->load($filePath);
        /**讀取excel文件中的第一個工作表*/
        $currentSheet = $PHPExcel->getSheet($sheetNum);
        /**取得最大的列號*/
        $allColumn = $currentSheet->getHighestColumn();
        /**取得一共有多少行*/
        $allRow = $currentSheet->getHighestRow();
        /**從第一行開始 全部原封不動讀取返回*/
        $result = [];

        for ($currentRow = 1; $currentRow <= $allRow; $currentRow++) {
            /**從第A列開始輸出*/
            for ($currentColumn = 'A'; $currentColumn <= $allColumn; $currentColumn++) {
                $cell = $currentSheet->getCellByColumnAndRow(ord($currentColumn) - 65, $currentRow);
                $val  = $cell->getValue();

                //如果是時間格式，則解析
                if ($cell->getDataType() == \PHPExcel_Cell_DataType::TYPE_NUMERIC) {
                    $cellstyleformat = $currentSheet->getStyle($cell->getCoordinate())->getNumberFormat();
                    $formatcode      = $cellstyleformat->getFormatCode();
                    if (preg_match('/^($[A−Z]*−[0−9A−F]*)*[hmsdy]/i', $formatcode)) {
                        $val = gmdate("Y-m-d", \PHPExcel_Shared_Date::ExcelToPHP($val));
                    } else {
                        $val = \PHPExcel_Style_NumberFormat::toFormattedString($val, $formatcode);
                    }
                    if (is_object($val)) {
                        $val = $val->__toString();
                    }
                }
                $result[$currentRow][] = (string) $val;
            }
            //如果整行都是空數據 刪除該行
            if (empty(array_filter($result[$currentRow]))) {
                unset($result[$currentRow]);
            }
        }
        return $result;
    }
}
