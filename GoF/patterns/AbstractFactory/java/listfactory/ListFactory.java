package listfactory;

import factory.*;

/**
 * リスト工場クラス
 */
public class ListFactory extends Factory {

  /**
   * リンクを作成する
   * 
   * @param caption 見出し
   * @param url     遷移先
   */
  @Override
  public Link createLink(String caption, String url) {
    return new ListLink(caption, url);
  }

  /**
   * お盆を作成する
   * 
   * @param caption 見出し
   */
  @Override
  public Tray createTray(String caption) {
    return new ListTray(caption);
  }

  /**
   * ページを作成する
   * 
   * @param title  タイトル
   * @param author 著者
   */

  @Override
  public Page createPage(String title, String author) {
    return new ListPage(title, author);
  }

}
