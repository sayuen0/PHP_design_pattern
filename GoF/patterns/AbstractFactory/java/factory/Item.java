package factory;

/**
 * HTMLタグ抽象クラス
 */
public abstract class Item {
  /**
   * 見出し
   */
  protected String caption;

  /**
   * コンストラクタ 見出しを指定
   * 
   * @param caption 見出し
   */
  public Item(String caption) {
    this.caption = caption;
  }

  /**
   * 見出しからHTMLタグを生成する
   */
  public abstract String makeHTML();

}
