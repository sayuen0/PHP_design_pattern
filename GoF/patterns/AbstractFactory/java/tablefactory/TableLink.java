package tablefactory;

import factory.Link;

/**
 * 表用のリンクデータを作成するクラス
 */
public class TableLink extends Link {

  public TableLink(String caption, String url) {
    super(caption, url);

  }

  /**
   * リンクを作成する
   * 
   */
  @Override
  public String makeHTML() {
    return "<td><a href='" + this.url + "'>" + this.caption + "</a></td>\n";
  }

}
