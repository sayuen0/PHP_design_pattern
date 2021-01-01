# Interpreterパターン

> **文法規則をクラスで表現する**

## 概要

言語単体で柔軟性が得られないときは、別言語のインタプリタを使え
他の人でも書ける

## その前に

DSL:ドメイン特化言語

色々な意味があるみたいで

あるところでは「ある言語の用途特価機能関数」みたいな文脈で使われていた
KotlinでHTMLを書くための「DSL」とか

## ユースケース

### ゲームシナリオの分岐

ゲームのシナリオ分岐するにあたり、PHPで柔軟な分岐に対応するのは無理があるので、yamlで分岐内容を書いて、PHPではその解析だけを行う

### SQL

ORマッパーでOOPからSQLに変換したい時とか、構文要素をオブジェクトに閉じ込めたらいいじゃない

## ソース

### Java

[include](../../patterns/dpsrc_2009-10-10/src/Interpreter/Sample/Node.java)
[include](../../patterns/dpsrc_2009-10-10/src/Interpreter/Sample/CommandListNode.java)
[include](../../patterns/dpsrc_2009-10-10/src/Interpreter/Sample/Context.java)
[include](../../patterns/dpsrc_2009-10-10/src/Interpreter/Sample/ProgramNode.java)
[include](../../patterns/dpsrc_2009-10-10/src/Interpreter/Sample/PrimitiveCommandNode.java)
[include](../../patterns/dpsrc_2009-10-10/src/Interpreter/Sample/ParseException.java)
[include](../../patterns/dpsrc_2009-10-10/src/Interpreter/Sample/CommandNode.java)
[include](../../patterns/dpsrc_2009-10-10/src/Interpreter/Sample/RepeatCommandNode.java)
[include](../../patterns/dpsrc_2009-10-10/src/Interpreter/Sample/Main.java)

### PHP

[include](../../patterns/Interpreter/index.php)
