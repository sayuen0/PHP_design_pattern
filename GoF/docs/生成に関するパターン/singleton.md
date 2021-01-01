# Singleton

神：人間からは干渉できないもの

絶対不変であり、どの人間にとっての共通の認識を持つ

その必要条件は

- 2度目以降に呼び出されると1度目と同じ実態を返す
- イミュータブルである

こと。

## やり方

1. コンストラクタをprivateにする
2. **唯一の**public staticなインスタンス生成メソッドを作成し、その中で一度だけ生成したインスタンスを返す

## メリット

クッソ重いインスタンスがアプリケーション内に一つしか生成されないことを約束できるので、メモリ節約になる

同時に複数インスタンスを管理しなくて良くなるので予期せぬバグを防げる

## 関連

これらのパターンはインスタンスが1つであることが多い

- Abstract Factory
- Builder
- Facade
- Prototype

## ソース

### Java

[include](../../patterns/dpsrc_2009-10-10/src/Singleton/Sample/Singleton.java)
[include](../../patterns/dpsrc_2009-10-10/src/Singleton/Sample/Main.java)

### PHP

[include](../../patterns/Singleton/index.php)
