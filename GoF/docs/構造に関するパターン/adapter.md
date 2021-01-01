# Adapter

「右と左の端子があっていなくて繋げないから、両端子を繋げられるオブジェクトを間に挟む」

## 目的

「本来の機能への委譲」

## 登場人物

- インタフェース: ユーザーがそういう名前で呼び出したいメソッドを持つ
  - fireとかcreateとか単純な名前
- Adapter: 挟む主体。インタフェースを実装する
- Adaptee: 挟まれて対応される主体

## やり方

2つある

### 1. インタフェースによる実装

1. クライアントから呼び出したい名前のシグネチャをインタフェースに置く
2. それを実装し、かつAdapteeを継承したAdapterクラスを作成する
3. Adapter内でインタフェースのメソッドをOverrideして、Adapteeのメソッドを呼び出す

### 2. 委譲による実装

1. クライアントから呼び出したい名前のシグネチャをインタフェースに置く
2. それを継承したAdapterクラスを作成し、プロパティにAdapteeを持たせる
3. スーパークラスのメソッドをオーバーライドして、自分が持つAdapteeのメソッドを呼び出す

## クラス図

### 1.インタフェースによる実装

![Adapter using inheritance UML class diagram \- Adapter パターン \- Wikipedia](https://upload.wikimedia.org/wikipedia/commons/thumb/f/fd/Adapter_using_inheritance_UML_class_diagram.svg/1920px-Adapter_using_inheritance_UML_class_diagram.svg.png)

### 2.クラスによる実装

![Adapter using delegation UML class diagram \- Adapter パターン \- Wikipedia](https://ja.wikipedia.org/wiki/Adapter_%E3%83%91%E3%82%BF%E3%83%BC%E3%83%B3#/media/%E3%83%95%E3%82%A1%E3%82%A4%E3%83%AB:Adapter_using_delegation_UML_class_diagram.svg)

## メリット(用途)

**既存クラスを改造する必要がなくなる**。本来クラスは書き換えたらテストしなけばいけない。

テストの通った既存クラスをラップすることで追加機能分だけをテストすれば良くなる

**既存クラスのソース内容は知る必要はない**。仕様がわかればAdapterで新しいクラスを作成できる。

## 他との関連

### [Decorator](/docs/構造に関するパターン/decorator.md)

元のオブジェクトをラップするという点で同一。

ただしDecoratorの目的は「本来の機能の拡張」。意味合いは「右と左の端子があっているところに、同じく端子のあう機能を追加した中間装置をかます」

## ソース

### Java

#### 1.インタフェースによる委譲の例

[include](../../patterns/dpsrc_2009-10-10/src/Adapter/Sample1/PrintBanner.java)
[include](../../patterns/dpsrc_2009-10-10/src/Adapter/Sample1/Print.java)
[include](../../patterns/dpsrc_2009-10-10/src/Adapter/Sample1/Main.java)
[include](../../patterns/dpsrc_2009-10-10/src/Adapter/Sample1/Banner.java)

#### 2.クラスによる委譲の例

[include](../../patterns/dpsrc_2009-10-10/src/Adapter/Sample2/PrintBanner.java)
[include](../../patterns/dpsrc_2009-10-10/src/Adapter/Sample2/Print.java)
[include](../../patterns/dpsrc_2009-10-10/src/Adapter/Sample2/Main.java)
[include](../../patterns/dpsrc_2009-10-10/src/Adapter/Sample2/Banner.java)

### PHP

[include](../../patterns/Adapter/index.php)
