# State

> **状態をクラスで表現する**


## 概要

オブジェクトの状態を変化させることで、処理内容を変えられるようにする。

## 登場人物

- State: 状態を表すインタフェース
- ConcreteState: 具体的な状態たち
- Context: 状況、前後関係

## クラス図

![1920px\-State\_Design\_Pattern\_UML\_Class\_Diagram\.svg\.png \(1920×694\)](https://upload.wikimedia.org/wikipedia/commons/thumb/e/e8/State_Design_Pattern_UML_Class_Diagram.svg/1920px-State_Design_Pattern_UML_Class_Diagram.svg.png)

## やり形

- Stateインタフェースを**シングルトンにする**
- ConcreteStateごとに「自分自身に関する状態」だけを実装する


## メリット

### 分割統治できる

- ConcreteStateごとの実装を考えればいいので、あるStateでは他のStateのことをある程度考慮から外すことができる(全部ではない)。

## 関連

- Singleton
  - ConcreteStateはSingletonであるべき。ある状態が複数いるのはおかしい
- FlyWeight
  - こっちでもいい

## 所感

これはいいね。
他の状態のことを意識しないのはとても良い。
状態遷移図と合わせて大変効力を発揮しそう

と思ったけど、ConcreteStateで別のStateに変更することを呼び出してたらあまり依存解消できてないのでは？
→Mediatorパターンで解決できる


## ソース

### PHP

[include](../../patterns/State/index.php)
