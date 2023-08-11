<?php

namespace TagMyDoc\SharePoint\Requests\Drive;

enum ConflictBehavior: string
{
    CASE FAIL = 'fail';
    CASE REPLACE = 'replace';
    CASE RENAME = 'rename';

}
