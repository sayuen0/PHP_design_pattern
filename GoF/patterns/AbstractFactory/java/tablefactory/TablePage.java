package tablefactory;

import factory.Item;
import factory.Page;

/**
 * 表ページを作成するクラス
 */
public class TablePage extends Page {

  public TablePage(String title, String author) {
    super(title, author);

  }

  @Override
  public String makeHTML() {
    StringBuffer buffer = new StringBuffer();
    buffer.append("<html><head><title>" + this.title + "</title></head>\n");
    buffer.append("<body>\n");
    buffer.append("<h1>" + this.title + "</h1>\n");
    buffer.append("<table>\n");
    for (Item item : this.content) {
      buffer.append("<tr>" + item.makeHTML() + "</tr>\n");
    }
    buffer.append("</table>\n");
    buffer.append("<hr><address>" + this.author + "</address>");
    buffer.append("</body></html>\n");
    return buffer.toString();
  }

}
