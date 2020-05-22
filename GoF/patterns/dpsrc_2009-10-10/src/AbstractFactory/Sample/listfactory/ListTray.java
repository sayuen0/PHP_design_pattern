package listfactory;

import factory.*;

/**
 * リスト内のお盆アイテムクラス
 */
public class ListTray extends Tray {

  /**
   * コンストラクタ
   */
  public ListTray(String caption) {
    super(caption);
  }

  /**
   * タグを作成する<br>
   * liのなかにulを作成して、その中に複数のliを置く
   * 
   * @return リストお盆
   */
  public String makeHTML() {
    StringBuffer buffer = new StringBuffer();
    buffer.append("<li>\n");
    buffer.append(this.caption + "\n");
    buffer.append("<ul>\n");
    for (Item item : this.tray) {
      buffer.append(item.makeHTML());
    }
    buffer.append("</ul>\n");
    buffer.append("</li>\n");

    return buffer.toString();
  }

}
