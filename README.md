# IT技術書レビューサイト　[![CircleCI](https://circleci.com/gh/drumnistnakano/IT-books-review-site/tree/master.svg?style=svg)](https://circleci.com/gh/drumnistnakano/IT-books-review-site/tree/master)  
IT関連技術書のレビュー投稿や閲覧、読んだ後にいいねができるサイトです。  
また、LINEによるログインを行うと、あなたが投稿したレビューへコメントがあった際に通知されます。  

![Gif](https://raw.github.com/wiki/drumnistnakano/IT-books-review-site/tutorial.gif)

# リンク
https://it-books-review-site.work/

ユーザ登録すると、だれでも技術書の紹介やレビューを投稿できます。  

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
