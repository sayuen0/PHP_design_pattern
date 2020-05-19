# Factory Methodパターン

> *インスタンス生成をサブクラスに任せる*

## 概要

インスタンス生成の方法をサブクラスで定めるが、具体的なクラス名は出さない

## 登場人物

- Product:生成されるインスタンスが持っているべきAPI
- Creator: Productを生成する抽象クラス 
  - **ConcreteProductについては何も知らない**ことがミソでありこのパターンのメリット
- ConcreteProduct
- ConcreteCreator

## クラス図

![Factory Method Pattern](https://upload.wikimedia.org/wikipedia/commons/8/8e/Factory_Method_UML_class_diagram.svg)

## やり方

- Creatorに以下を用意する
  1. Product型を返す抽象生成メソッド
  2. それを内部で呼び出す、protectedでfinalな具象メソッド
  3. その中で毎回行いたいprotectedな抽象メソッド(インスタンス生成時に必ずさせたい動作)


## メリット(用途)


### オブジェクトの生成過程の隠蔽と集中管理


オブジェクト生成の方法に注目したパターン


単純な生成クラスではなくテンプレートメソッド的なオブジェクト準備の過程をabsractメソッドに定義して、**オブジェクト生成と準備を抽象化**

多様なインスタンス生成を請け負うオブジェクト生成は強い依存を生むので、切り離すだけでも大きなメリットがある

つまり、**インスタンス生成時に決まった手順でhogehogeする**を抽象クラスから強制できる



## ソース

### Java 

[include](../../patterns/dpsrc_2009-10-10/src/FactoryMethod/Sample/framework/Factory.java)
[include](../../patterns/dpsrc_2009-10-10/src/FactoryMethod/Sample/framework/Product.java)
[include](../../patterns/dpsrc_2009-10-10/src/FactoryMethod/Sample/idcard/IDCardFactory.java)
[include](../../patterns/dpsrc_2009-10-10/src/FactoryMethod/Sample/idcard/IDCard.java)
[include](../../patterns/dpsrc_2009-10-10/src/FactoryMethod/Sample/Main.java)


### PHP

復習:
[templatemethod](../振る舞いに関するパターン/templateMethod.md)では、処理の流れを実際の処理から抽象化した
それぞれdoActionという名前で、
validateしてエラーがあればエラーを投げて、
なければdoMainするという流れを踏んだ


[include](../../patterns/FactoryMethod/index.php)


別事例

- [PHPによるデザインパターン入門 \- Factory Method〜生成処理と使用処理を分離する \- Do You PHP はてブロ](http://shimooka.hateblo.jp/entry/20141215/1418620242)


## シナリオ
### CSVかXMLかの方

今回の実装。上記リンクから趣旨を抜き出す

- ある既存のCSV出力メソッドを,XMLにも対応させたいとする
- ifでCSVかXMLか分岐させればできそう
- しかしさらにファイル形式の対応を増やしていけば、if文が増えるばかり

ユーザがやりたいことはファイル形式が何であれ

1. 読み込む read
2. 表示する display

これだけ。

具体的な読み込み方法や表示方法はそれぞれのファイル形式に対応させたファクトリに任せる



### システム開発

ベンダー企業とクライアントがいる

とあるクライアントはデータセンターを運営しようとして、データセンターシステムを外注しようとする。
とあるクライアントはPOSシステムを外注しようとする。

クライアントはベンダーの営業(ConcreteFactory)に
**発注して納品待ち** をする。だけ。どんな開発体制が取られるかは(監査を入れるでもしようとしなければ)ベンダー側に任せる

ベンダーは受注内容から
データセンターシステムの受注ならその道のスペシャリストに、
POSシステムならその道のスペシャリストに開発をさせる。

ベンダーのエンジニアは共通して「開発」と「納品」ができるが、それぞれ手法は専門領域や開発スタイルから完全に異なる


### 料理

釣りが趣味のおっさんと持込OKレストラン

おっさんは釣った魚をレストランに渡して、調理済みの魚料理をもらう
レストランは魚の種類によって、一番美味しく食べられる調理方法が可能な料理人に魚を調理させる


登場人物

- おっさん: クライアント
- レストラン：ファクトリ
- 料理人：プロダクトの作り手。ファクトリに生成される
- 料理：プロダクト

