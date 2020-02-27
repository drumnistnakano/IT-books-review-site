[![CircleCI](https://circleci.com/gh/drumnistnakano/IT-books-review-site/tree/master.svg?style=shield)](https://circleci.com/gh/drumnistnakano/IT-books-review-site/tree/master)  [![Maintainability](https://api.codeclimate.com/v1/badges/c3490185b36e4ae85c24/maintainability)](https://codeclimate.com/github/drumnistnakano/IT-books-review-site/maintainability)
# IT技術書レビューサイト　
技術書のレビュー投稿や閲覧、読んだ後にいいねができるサイトです。    
また、LINEによるログインを行うと、あなたが投稿したレビューへコメントがあった際に即時通知されます。   
どうしてもコメントされたくないという方は、コメント非表示ボタンでコメントできないように設定できます。  

![Gif](https://raw.github.com/wiki/drumnistnakano/IT-books-review-site/demo.gif)  

# リンク
https://it-books-review-site.work/

注意：  
メールアドレス登録、またはLineログインでユーザ登録してください。  
どうしても、登録したくない方は下記アカウントでログインしてください。  

(テストアカウント）  
メールアドレス：nakano@nakano  
パスワード：nakanosan  

# 使用技術
* PHP 7.3
* Laravel 6.0
* nginx 1.16.1
* MySQL 5.7
* Bootstrap 4
* Github
* AWS(VPC,EC2,ELB,RDS,S3,Route53,Lambda,CloudWatchEvent,ACM,CloudFront,Cloud9)
* CircleCI 2.0

# AWSアーキテクチャ
![AWSアーキテクチャ](https://user-images.githubusercontent.com/30113636/75353340-95636000-58ee-11ea-8d38-50940898879a.png)


# 機能一覧
* ユーザー登録
* ログイン、ログアウト
* 画像アップロード
* 登録されているレビュー一覧の表示
* 一覧表示のページネーション
* いいね機能
* コメント投稿
* コメントオフ機能
* Line OAuth認証
* コメントのLine通知

# ER図
<img width="899" alt="スクリーンショット 2020-02-26 23 52 48" src="https://user-images.githubusercontent.com/30113636/75356397-40761880-58f3-11ea-9e72-2920b921836d.png">

# システム自動起動&自動停止
CloudWatch EventとLambdaを使って、システムの起動と停止を自動的に行うようにした。  
起動停止のソースコードは以下を参照。  

[EC2起動停止](https://github.com/drumnistnakano/start-stop-EC2)  
[RDS起動停止](https://github.com/drumnistnakano/start-stop-RDS)  
