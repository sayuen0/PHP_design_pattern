 # スレッドとは

プログラムを実行する主体。

## シングルスレッドのプログラム

[include](../patterns/dp2src_2006-04-04/src/Introduction1/SingleThread/Main.java)

```
javac main java
java main
```

ここで動くのが**メインスレッド**。mainメソッドを実行する

Javaでは舞台裏でGCとかGUI関連のスレッドとかは動いている

## Threadクラスのrunとstart

- java.lang.Threadを実装したクラスのrunをオーバーライドする
- 上記スレッドクラスのインスタンスに対しstartを呼び出す


[include](../patterns/dp2src_2006-04-04/src/Introduction1/TwoThreads/MyThread.java)
[include](../patterns/dp2src_2006-04-04/src/Introduction1/TwoThreads/Main.java)



### 逐次・並列・並行

- 逐次 シーケンシャル: 複数の仕事を順番に処理。つまりシングルスレッド
- 並列 パラレル: 複数の仕事を同時に処理
- 並行 コンカレント: 1つの仕事をどんな順序でも処理してよい複数の作業に分割



# スレッドの起動

## Threadのサブクラスを使う

1. Threadを継承する
2. Threadサブインスタンスに対してstart()する

[include](../patterns/dp2src_2006-04-04/src/Introduction1/PrintThread/PrintThread.java)
[include](../patterns/dp2src_2006-04-04/src/Introduction1/PrintThread/Main.java)

インスタンスを生成してもスレッドが起動するわけではない。startして初めてスレッドは起動する

※runの呼び出しはMainスレッドが行う。
したがって以下のような書き方をしても、これはシングルスレッドプログラムである

```java
public class Main{
  public static void main(String[] args){
    new PrintThread("*").run();
    new PrintThread("-").run();
  }
}
```

## Runnableインタフェースを使う

1. Runnableを実装する
2. Runnable実装クラスをThreadに渡してstartする

[include](../patterns/dp2src_2006-04-04/src/Introduction1/Printer/Printer.java)
[include](../patterns/dp2src_2006-04-04/src/Introduction1/Printer/Main.java)


### ThreadFactory
[include](../patterns/dp2src_2006-04-04/src/Introduction1/jucThreadFactory/Printer.java)
[include](../patterns/dp2src_2006-04-04/src/Introduction1/jucThreadFactory/Main.java)


## スレッドの一時停止

Thread.sleep()で、**この文を実行したスレッド**が停止する。


[include](../patterns/dp2src_2006-04-04/src/Introduction1/Sleep/Main.java)


## スレッドの排他制御

データ・レース: スレッド同士が同時に実行されることにより引き起こされる不具合

これを対処するには**synchronized**する(**同期メソッド**)

synchronizedされたメソッドはいちどきには1つのスレッドでしか実行できない

同期メソッドが一つのスレッドで実行されているとき、スレッドは「**ロックを取っている(acquires lock)**」

同期メソッドの実行によってスレッドは**ロックを解放する(release lock)**


[include](../patterns/dp2src_2006-04-04/src/Introduction1/Sync/Bank.java)


# スレッドの協調

全てのインスタンスはwait set を持つ

wait set はそのインスタンスのwaitメソッドを実行して動作を停止しているスレッドの集合。インスタンスごとのスレッドの待合室

インスタンスが持つなので、MainからみたThreadA, ThreadBといった具合か。

スレッドはwait()を実行してwait setに入り、以下が起こるまでwait setから出てこない

- notifyされる
- notifyallされる
- interruptされる
- waitがタイムアウトする



```java
obj.wait(); //objインスタンスでスレッドが待合室に入った状態
```


- ロックをとったスレッドがwaitすると、スレッドはロックを解放する
- ロックを取ったスレッドがnotifyすると、wait setにいる次のスレッドが待ち状態になり、notifyスレッドがロックを解放したとき次にロックを取得する
