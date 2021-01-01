# Commandパターン

> **命令をクラスにする**

## 概要

命令の集まりを履歴として保存して、取り消したりやり直したりできる

## 登場人物

- Command: インタフェース
- ConcreteCommand
- Reciever: Commandの命令実行対象
- Client: ConcreteCommandを生成して、Recieverを割り当てる
- Invoker: 命令実行開始役

## クラス図

![Command\_Design\_Pattern\_Class\_Diagram\.png \(557×353\)](https://upload.wikimedia.org/wikipedia/commons/8/8e/Command_Design_Pattern_Class_Diagram.png)

## やり方

(やり方いまいち理解してない...)

## メリット(用途)

## 関連

- Composite: マクロコマンド(コマンドの集まり)も、コマンドである
- Memento: コマンド履歴の保存に使える
- Prototype: コマンドの複製に使える

## ソース

### Java

[include](../../patterns/dpsrc_2009-10-10/src/Command/Sample/command/Command.java)
[include](../../patterns/dpsrc_2009-10-10/src/Command/Sample/command/MacroCommand.java)
[include](../../patterns/dpsrc_2009-10-10/src/Command/Sample/drawer/Drawable.java)
[include](../../patterns/dpsrc_2009-10-10/src/Command/Sample/drawer/DrawCommand.java)
[include](../../patterns/dpsrc_2009-10-10/src/Command/Sample/drawer/DrawCanvas.java)
[include](../../patterns/dpsrc_2009-10-10/src/Command/Sample/Main.java)

### PHP

[include](../../patterns/Command/ShellCommand.php)
[include](../../patterns/Command/MakeDirectoryCommand.php)
[include](../../patterns/Command/RemoveDirectoryCommand.php)
[include](../../patterns/Command/ShellScript.php)
[include](../../patterns/Command/FileSystem.php)
[include](../../patterns/Command/index.php)
