# Template Method

> *具体的な処理をサブクラスに任せる*


## 概念

振る舞いを歯抜けで抽象させて、それをサブクラスが具体で補う

これに関しては漫画があまりにわかりやすいのでそれを半睡

新しくツイッターボットを作ることを考える。「ドロリッチなう」とツイートしたユーザにPRリプを送る

昔、ファボ10000超のツイートをした人に引用許可願いのリプを送るボットを作成していた。これをコピペするのか

しかし、ツイッターAPIの仕様が変われば、コピペした2者の修正が必要になる

そこで、全体の共通化はできているが内部の処理が歯抜けになった抽象メソッドを用意する

それを継承した具象が歯抜けを埋めて、個々の機能に対応させる。


TwitterBot抽象

- トークンの管理
- フェッチ
- (判別ルール)
- HTTP通信
- (送信内容決定)
- エラー処理


以上の部分を


PRボット具象

- 「ドロリッチなう」と呟いた人
- PRリプ



引用許可願い具象

- 10000ファボのツイートをした人
- 引用願い


で穴埋めして運用する

## 登場人物

- 抽象クラス
- 具象クラス

これだけ！


## クラス図

![Template Method pattern](https://upload.wikimedia.org/wikipedia/commons/2/2a/Template_Method_UML_class_diagram.svg)

## やり方

1. 実装は決めないが呼び出し順は決めたメソッドを持つ抽象クラスを作成する
2. 実装内容を決めない抽象メソッドを配置する
   - サブクラスからしか呼べないように可視性を**protected**にしておくとなお良し
3. 抽象クラス内に**抽象メソッドの呼び出し順を定義した具体メソッド**を配置する。これがテンプレートメソッド
   - Javaなら、これをfinalでオーバーライド不可にして置くとなお良し
4. 継承し、抽象メソッドをオーバーライド
5. クライアントからはテンプレートメソッドを呼び出す


## メリット(用途)

**抽象クラスのテンプレートメソッドに誤りが見つかったら、(具象には手をつけず)それだけ直せば済む。**
もしコピペ実装していたら修正クラスファイルが増える。

## ユースケース

### 単体テストフレームワーク

beforeEachして、testHogehogeして、afterEachする。この順番はフレームワーク内で決められているので、TemplateMethodそのものであるが、フレームワークではなくユーザが中身を書く。

## 関連パターン

### Factory Method

Template Methodをインスタンス生成に使うとFactory Method。

### Strategy

- Template Method : **継承**によりプログラムの動作を変更
  - スーパクラスで大枠の振る舞いを決めてサブクラスで実装
- Strategy: **委譲**によりプログラムの動作を変更
  - アルゴリズム全体をごっそり切り替える

## ソース

### Java

[include](../../patterns/dpsrc_2009-10-10/src/TemplateMethod/Sample/AbstractDisplay.java)
[include](../../patterns/dpsrc_2009-10-10/src/TemplateMethod/Sample/CharDisplay.java)
[include](../../patterns/dpsrc_2009-10-10/src/TemplateMethod/Sample/StringDisplay.java)
[include](../../patterns/dpsrc_2009-10-10/src/TemplateMethod/Sample/Main.java)

### PHP

[include](../../patterns/TemplateMethod/index.php)
