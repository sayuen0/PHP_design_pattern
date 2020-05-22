# Strategy

> **アルゴリズムをごっそり切り替える**


## 概要

データ構造に対して適用する一連のアルゴリズムをカプセル化し、アルゴリズムの切替えを容易にする。

## 登場人物

- Strategy: 戦略名インタフェース
- ConcreteStrategy: 戦略を実装 **(具体的な作戦、方策、方法、アルゴリズムの切り替え)**
- Context: Strategy利用者


## クラス図

![500px\-StrategyPatternClassDiagram\.svg\.png \(500×213\)](https://upload.wikimedia.org/wikipedia/commons/thumb/0/08/StrategyPatternClassDiagram.svg/500px-StrategyPatternClassDiagram.svg.png)

## やり方

- ConcreteStrategy達にStrategyを実装させる
- Contextは**ConcreteStrategyインスタンスを持つ**が、Strategyインタフェースを呼び出す

なんのクラスを呼び出すかについての指定は、**リフレクション**により動的に行うことで、Contextはクラス名を知る必要がなくなる


## メリット(用途)


## 所感

これただのインタフェースの使い方では?


## ソース

### PHP

[include](../../patterns/Strategy/index.php)
