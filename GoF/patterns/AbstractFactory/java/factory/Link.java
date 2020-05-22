package factory;

/**
 * リンクタグを生成する抽象クラス
 */
public abstract class Link extends Item {

  /**
   * リンクの参照先
   */
  protected String url;

  /**
   * コンストラクタ
   * 
   * @param caption 見出し
   * @param url     リンク
   */
  public Link(String caption, String url) {
    super(caption);
    this.url = url;
  }

}
