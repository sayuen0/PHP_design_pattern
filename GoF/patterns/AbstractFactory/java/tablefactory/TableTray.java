package tablefactory;

import factory.Item;
import factory.Tray;

public class TableTray extends Tray {

  public TableTray(String caption) {
    super(caption);
  }

  @Override
  public String makeHTML() {
    StringBuffer buffer = new StringBuffer();
    buffer.append("<td>\n");
    buffer.append("<table width='100px'>\n<tr>\n");
    buffer.append("<td colspan='" + this.tray.size() + "'>" + this.caption + "</td>\n");
    buffer.append("</tr>\n");
    buffer.append("<tr>\n");
    for (Item item : this.tray) {
      buffer.append(item.makeHTML());
    }
    buffer.append("</tr>\n");
    buffer.append("</table>\n");
    buffer.append("</td>");

    return buffer.toString();
  }

}
