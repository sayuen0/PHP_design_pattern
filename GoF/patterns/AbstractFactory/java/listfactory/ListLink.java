package listfactory;

import factory.*;

/**
 * リストページ内のリンクアイテム
 */
public class ListLink extends Link {
  public ListLink(String caption, String url) {
    super(caption, url);
  }

  /**
   * リンクタグ実物を作成して返す
   * 
   * @return リンクタグ
   */

  @Override
  public String makeHTML() {
    return "<li><a href=\"" + this.url + "\">" + this.caption + "</a></li>\n";
  }

}
