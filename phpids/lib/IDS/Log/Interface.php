<?php

interface IDS_Log_Interface
{
    /**
     * Interface method
     *
     * @param IDS_Report $data the report data
     * 
     * @return void 
     */
    public function execute(IDS_Report $data);
}
