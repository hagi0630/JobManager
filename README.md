# JobManager
・就活にあたり、マイページのIDやパスワード、タスク、期日などを管理できるアプリケーションです。
・公開するまでは、今のところXAMPPを使うことを想定していますがいずれは変えたいです。XAMPPではデータベース上にJobという名前のデータベースを構築し、そこにuser、companyという名前のテーブルを格納
userはid(unique,varchar）,pwd(varchar）
companyはid(unique,int),user_id(str),name(varchar),url(varchar),mypage_id(varchar),pwd(varchar),task1(varchar),due1(date),task2(varchar),due2(date),task3(varchar),due3(date)
company:id:異なるユーザーIDもまとめてデータベースに登録するので、通し番号。ユニークID。name:会社名、url:マイページURL,mypage_id:マイページID、pwd:マイページパスワード、task1から3:SPIなどタスク。due1から3：それぞれの期日
また、DBManagerのパスワードなどは変更する必要があります
