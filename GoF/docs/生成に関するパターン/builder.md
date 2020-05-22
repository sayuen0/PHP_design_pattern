# Builderパターン

何らかの**構造**を持った成果物を組み立てる際


## 概要

人間がHTMLで文章を書くとき、
HTMLのシンタックスをいちいち組み立てるのではなく、コンテンツ(とタグの種類)を与えたら、正しいシンタックスのタグを自動生成してほしいという考え。
そのタグの自動生成はBuilderクラスにやらせる。

**人間はBuilderの具体的な挙動を知らなくても良い。**


## 登場人物

- Builder: インスタンス生成のためのAPIを定める抽象クラス
- ConcreteBuilder: BuilderのAPIを実装し、具体的なものを作る
- Director: Builderインタフェースを使ってインスタンスを生成する
  - **ConcreteBuilderの種類に関係なく使えるように、Builderメソッドのみ呼ぶ**
- Client: 利用者。Main


## やり方

1. Builderにインスタンス生成のための抽象メソッドを定義する
2. DirectorはBuilder型のプロパティを持ち、Builder型のメソッドを呼ぶ
3. MainはConcreteBuilderとDirectorを生成し、Directorに「作れ」と一言言う。
   -  DirectorはBuilderメソッドを通じてConcreteBuilderから成果物を作る



## クラス図
![](https://upload.wikimedia.org/wikipedia/commons/thumb/f/f3/Builder_UML_class_diagram.svg/1920px-Builder_UML_class_diagram.svg.png)
wikipediaより

## メリット(用途)


「交換可能性」: 入れ替えられるからこそ部品としての信頼性が高くなる

- ClientはBuilderのメソッドは**知らない**。ClientがDirectorにお願いするとDirectorのなかでむにゃむにゃ仕事が進んでいい感じの成果物ができている
- DirectorはConcreteBuilderの実装を**知らない**。知らないのでHTMLBuilderだろうがMarkdownBuilderだろうが問題なく動かせる。
- 近い将来扱う書式が増えそうなとき有効なパターン

## 応用例

### CSV, XML形式を作り分ける

- ディレクタは属性と値だけ指定する
- ビルダがデリミターやタグなどに従って適切に配置する


### SQLを組み立てる

- SELECT, UPDATE, INSERTなど組み立てたいクエリの見出し
- テーブル名
- 属性
- 条件

などを指定すると、ビルダが勝手にSQLを組み立ててくれる

# ソース

```php
<?php

/**
 * 複数のディレクタと複数のビルダ
 * 多種多様なことを実現する
 * 
 * 比較的業務に落とし込みやすいが、
 * 最初からBuilderにすることを見越すのは難しい
 * リファクタリング時に構造を見極めるのが現実的
 * 
 * ビルダの構造
 * ディレクタ：ビルダを使う機能を持つ その上で中身を作る
 * ビルダ：インスタンスを生成、目的に応じたプロパティを付与
 * ビルディング：生成物
 * 
 */



//  Builder

interface DocumentBuilder
{
  public function setTitle($str);
  public function setHeader($str);
  public function setBody($str);
  public function setFooter($str);
  public function getResult();
}


// Director 中身を作る
// レポート書きたい人

class ReportDirector
{
  private $builder;

//PHPはインタフェースを変数型にできる?
  public function __construct(DocumentBuilder $builder)
  {
    $this->builder = $builder;
  }

  public function build()
  {
    $this->builder->setTitle("報告書");
    $this->builder->setHeader("失敗");
    $this->builder->setBody("プロトタイプを無駄にする");
    $this->builder->setFooter("次頑張りましょう");
    return $this->builder->getResult();
  }
}


// director2 
// 日記書きたい人

class DiaryDirector
{
  private $builder;

  public function __construct(DocumentBuilder $builder)
  {
    $this->builder = $builder;
  }

  public function build()
  {
    $this->builder->setTitle("日記2020/03/12");
    $this->builder->setHeader("いい日だった");
    $this->builder->setBody("プロトタイプを多数生成");
    $this->builder->setFooter("明日も頑張る");
    return $this->builder->getResult();
  }
}



// builder1 HTMLビルダ

class HtmlBuilder implements DocumentBuilder
{
  private $header = null;
  private $body = null;
  private $footer = null;
  private $title = null;

  public function getBody()
  {
    return $this->body;
  }
  public function getFooter()
  {
    return $this->footer;
  }
  public function getHeader()
  {
    return $this->header;
  }
  public function getTitle()
  {
    return $this->title;
  }

  public function setTitle($title)
  {
    $this->title = $title;
  }

  public function setHeader($header)
  {
    $this->header = $header;
  }

  public function setBody($body)
  {
    $this->body = $body;
  }

  public function setFooter($footer)
  {
    $this->footer = $footer;
  }

  public function getResult()
  {
    ob_start();
?>
    <html>

    <head>
      <title><?= htmlspecialchars($this->title, ENT_QUOTES) ?></title>
    </head>

    <body>
      <h1><?= htmlspecialchars($this->header, ENT_QUOTES) ?></h1>

      <div>
        <p>
          <?= htmlspecialchars($this->body) ?>
        </p>
      </div>
      <hr>
      <div><?= htmlspecialchars($this->footer, ENT_QUOTES) ?></div>
    </body>

    </html>
  <?php return ob_get_clean();
  }
}

// builder2 マークダウン ビルダ

class MarkdownBuilder implements DocumentBuilder
{
  private $header = null;
  private $body = null;
  private $footer = null;
  private $title = null;

  public function getBody()
  {
    return $this->body;
  }
  public function getFooter()
  {
    return $this->footer;
  }
  public function getHeader()
  {
    return $this->header;
  }
  public function getTitle()
  {
    return $this->title;
  }

  public function setTitle($title)
  {
    $this->title = $title;
  }

  public function setHeader($header)
  {
    $this->header = $header;
  }

  public function setBody($body)
  {
    $this->body = $body;
  }

  public function setFooter($footer)
  {
    $this->footer = $footer;
  }

  public function getResult()
  {
    ob_start();
  ?>
    # <?= htmlspecialchars($this->title, ENT_QUOTES) ?>
    ## <?= htmlspecialchars($this->header, ENT_QUOTES) ?>

    <?= htmlspecialchars($this->body, ENT_QUOTES) ?>

    ------------------------------------------
    <?= htmlspecialchars($this->footer, ENT_QUOTES) ?>
<?php return ob_get_clean();
  }
}



$hr = new ReportDirector(new HtmlBuilder());//HTMLでレポート
$mr = new ReportDirector(new MarkdownBuilder());//Markdownでレポート

print($hr->build());
print($mr->build());

// 日記を生成
$hd = new DiaryDirector(new HtmlBuilder());
$md = new DiaryDirector(new MarkdownBuilder());


echo $hd->build();//directorがbuildするのではなくてプロパティのbuilderが手順に従ってbuildしてくれる
echo $md->build();


// !いずれもbuild()というAPIだけで生成できているのである。

```


## ソースのメモ書き

- 複雑な構造物とか文法を持った言語の生成を、有能なロボット(ビルダに任せる)

- 書式についてHTMLなのかMarkdownなのかで２種類のビルダが登場する
- 書きたい内容について日記なのかレポートなのかで2種類のディレクタが登場する


- 書きたい内容と書式の分離ができていることは美味しい
- ディレクタは文法エラーなどの書式に関する過ちを完全に防げる

- ディレクタは書きたい内容だけ指定して、ビルダに作ることを任せればビルダは受け取った内容から正しい書式でプロダクトを生成する
