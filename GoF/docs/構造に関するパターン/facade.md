# facadeパターン

> **シンプルな窓口**

## 概要

複雑な手続き、複数オブジェクトの、それも順番があっていることが必須な呼び出しなどを「よく知っている窓口」であるファサードに任せる。
クライアントからは内部の状態が見えないのが嬉しいところ


## 登場人物

- Facade(正面):とてもシンプルな利用者にわかりやすいインタフェース
- システムを構成するその他大勢のModule:**Facadeのことは意識しない**がFacadeから呼び出されて仕事を行う
- Client: Facadeの利用者

## クラス図

![1920px\-Facade\_UML\_class\_diagram\.svg\.png \(1920×960\)](https://upload.wikimedia.org/wikipedia/commons/thumb/d/d4/Facade_UML_class_diagram.svg/1920px-Facade_UML_class_diagram.svg.png)

## やり方

- Facadeにはクライアントからアクセスできるmainメソッドを置く
- mainのなかで(privateな)インスタンスたちへの呼び出しを行う

## メリット(用途)

- インタフェースを少なくできる
  - 利用者は「まずAをして次にBをして,,,」という手順を覚える必要がなくなる

## 拡張して考える

- 小さいFacadeをModuleとしてみなし、それらを束ねる大きいFacadeを実装して、大きなシステムを実装する **(再帰的にFacadeパターンする)**


## ソース

```php
<?php

/**
 * 窓口を統一して複雑度を追い出す
 * MVCのC
 * コツは
 * 複雑さはサブシステムに追い出すこと
 * 一つのファサードを多機能にしないこと
 */


/**
 * facade: 窓口。workerのdoMethodを管理
 * runで全て実行
 * worker: doMethodを持つ
 * 
 */


class Facade
{
  public function run()
  {
    $obj1 = new Worker1();
    $obj2 = new Worker2();
    $obj3 = new Worker3();

    if ($obj1->doMethod()) {
      return $obj2->doMethod();
    } else {
      return $obj3->doMethod();
    }
  }
}


interface IWorker
{
  public function doMethod();
}

class Worker1 implements IWorker
{
  public function doMethod()
  {
    return true;
  }
}

class Worker2 implements IWorker
{
  public function doMethod()
  {
    return "worker2";
  }
}



class Worker3 implements IWorker
{
  public function doMethod()
  {
    return "worker3";
  }
}


$obj = new Facade();

// workerが見えないのでスッキリする

print $obj->run();

```
