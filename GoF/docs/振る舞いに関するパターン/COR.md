# Chain Of Responsibility

> **責任のたらい回し**

## 概要

複数のオブジェクトを鎖繋ぎして、そのオブジェクトの鎖を順次渡り歩いて目的のオブジェクトを決定する

## 登場人物

- Handler: 要求を処理するインタフェース
  - **次のHandlerを持つ**
  - 要求が飲めないとき**次のHandlerに処理を投げる**
- ConcreteHandler(Resolver): 要求処理を実装
- Client(Sender): ConcreteHandlerに要求を出す

## クラス図(&シーケンス図)

![W3sDesign\_Chain\_of\_Responsibility\_Design\_Pattern\_UML\.jpg \(700×240\)](https://upload.wikimedia.org/wikipedia/commons/6/6a/W3sDesign_Chain_of_Responsibility_Design_Pattern_UML.jpg)

## やり方

- ConcreteHandlerに解決条件・解決できないとき次に渡すHanlder、解決処理を持たせる
- Clientは最初のConcreteHandlerに対して一度だけ要求を投げる

## メリット(用途)

- 「誰かが解決してくれる」
  - 要求者であるClientが解決者を知っている(解決者に依存する)のはよくないが、たらい回しにすることで依存を解消できる

## ソース

### PHP

[include](../../patterns/COR/index.php)
