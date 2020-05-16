package factory;

import java.util.ArrayList;
import java.util.List;

/**
 * お盆(箇条書きリスト)作成抽象クラス <br> 見出しを持ち、複数の子要素を持つ構造
 */
public abstract class Tray extends Item {
  /**
   * お盆
   */
  protected List<Item> tray = new ArrayList<Item>();

  /**
   * コンストラクタ
   * 
   * @param caption 見出し
   */
  public Tray(String caption) {
    super(caption);
  }

  /**
   * 要素をお盆に追加する
   * 
   * @param item 要素
   */
  public void add(Item item) {
    this.tray.add(item);
  }
}
