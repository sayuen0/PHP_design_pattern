package factory;

/**
 * 抽象工場クラス
 */
public abstract class Factory {
  /**
   * 工場クラス名を指定し、そのオブジェクトを返す
   * 
   * @param className 工場クラス名
   * @return そのFactoryインスタンス
   */
  public static Factory getFactory(final String className) {
    Factory factory = null;
    try {
      try {
        factory = (Factory) Class.forName(className).newInstance();
      } catch (InstantiationException | IllegalAccessException e) {
        e.printStackTrace();
      }
    } catch (final ClassNotFoundException e) {
      System.out.println("クラス:" + className + "が見つかりません");
      e.printStackTrace();
    }
    return factory;
  }

  /**
   * リンクを作成する
   * 
   * @param caption
   * @param url
   * @return
   */
  public abstract Link createLink(String caption, String url);

  /**
   * お盆を作成する
   * 
   * @param caption
   * @return
   */
  public abstract Tray createTray(String caption);

  /**
   * ページそのものを作成する
   */
  public abstract Page createPage(String title, String author);

}
