package factory;

import java.io.*;
import java.util.ArrayList;
import java.util.List;

/**
 * ページ抽象クラス<br>
 * 題名、ページ製作者、要素を追加してHTMLファイルを出力する
 */
public abstract class Page {

  /**
   * 題名
   */
  protected String title;
  /**
   * ページ作成者
   */
  protected String author;

  /**
   * 要素リスト
   */
  protected List<Item> content = new ArrayList<Item>();

  /**
   * コンストラクタ
   * 
   * @param title  題名
   * @param author ページ作成者
   */
  public Page(String title, String author) {
    this.title = title;
    this.author = author;
  }

  /**
   * 要素を追加する
   * 
   * @param item 要素
   */
  public void add(Item item) {
    this.content.add(item);
  }

  /**
   * HTMLを整形して出力する
   */
  public void output() {
    try {
      String filename = this.title + ".html";
      Writer writer = new FileWriter(filename);
      writer.write(this.makeHTML());
      writer.close();
      System.out.println(filename + "を作成しました。");
    } catch (IOException e) {
      e.printStackTrace();
    }
  }

  /**
   * HTMLを生成する
   */
  public abstract String makeHTML();
}
