<?php
// エラー処理用
function es($str,$charset="UTF-8"){
    print htmlspecialchars($str,ENT_QUOTES,$charset);
}