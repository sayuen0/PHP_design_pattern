# Flyweightパターン

## 概要

- 等価なオブジェクトは共有したら軽量化できるよねって話


## 登場人物

- ファクトリ: 生成するやつ
- フライウェイト: 軽くしたいやつ
## やり方

1. ファクトリはフライウェイトオブジェクトをメンバーに持つ
2. publicでstaticな、1度目の呼び出しだけ「生成」し2度目以降の呼び出しはすでに生成したやつを返すgetInstanceメソッドを持つ


## クラス図

![](https://upload.wikimedia.org/wikipedia/commons/b/be/Flyweight_UML_class_diagram.svg)

