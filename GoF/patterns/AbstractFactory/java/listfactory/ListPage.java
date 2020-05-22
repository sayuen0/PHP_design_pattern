package listfactory;

import factory.*;

public class ListPage extends Page {

  /**
   * コンストラクタ
   * 
   * @param title  題名
   * @param author 著者
   */
  public ListPage(String title, String author) {
    super(title, author);
  }

  @Override
  public String makeHTML() {
    StringBuffer buffer = new StringBuffer();
    buffer.append("<html><head><title>" + this.title + "</title></head>\n");
    buffer.append("<body>\n");
    buffer.append("<h1>" + this.title + "</h1>\n");
    buffer.append("<ul>\n");
    for (Item item : this.content) {
      buffer.append(item.makeHTML());
    }
    buffer.append("</ul>\n");
    buffer.append("<hr><address>" + this.author + "</address>");
    buffer.append("</body></html>\n");
    return buffer.toString();
  }

}
