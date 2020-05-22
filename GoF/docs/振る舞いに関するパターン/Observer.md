# Observerパターン

> **状態の変化を通知する**

## 概要

別名**Pub-Sub(Publish-Subscribe)**パターン

- Publish: 発行
- Subscribe: 購読


## 登場人物

- Subject: 観察される側のインタフェース
  - Observerに自身の変化をnotifyする
- ConcreteSubject
- Observer: 監視役。Subjectから「状態が変わりましたよ」と通知を受けるインタフェース
  - 一つのSubjectを監視する**Observerは複数存在して良い**
- ConcreteObserver

## クラス図

![Observer\-pattern\-class\-diagram\.png \(600×320\)](https://upload.wikimedia.org/wikipedia/commons/e/e2/Observer-pattern-class-diagram.png)

## やり方

- SubjectにObserver達を持たせる
- Observerにupdate(Subjectの状態変化があったことを受け取り、何かする)を実装
- Subjectの状態変化があったら、Observer全員に処理を促す
  - その際Subject自身のインスタンス情報をObserverに渡すと、状態ごとの何かができていいよね


## メリット(用途)

交換可能性

- ConcreteSubjectはObserverには依存しているがConcreteObserverには依存していない
- ConcreteObserverはSubjectには依存しているがConcreteSubjectには依存していない

## 関連

- Meditator
  - 共通点: 複数の対象に状態変化を通知
  - 相違点(目的の違い)
    - Mediator: **処理を中央化**する
    - Observer: 個々に状態変化を通知して**同期を取る**

## ソース

### PHP

[include](../../patterns/Observer/index.php)
