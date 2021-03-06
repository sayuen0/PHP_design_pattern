import factory.*;

public class Main {
  public static void main(String[] args) {
    if (args.length != 1) {
      System.out.println("Usage : java Main class.name.of.ConcreteFactory");
      System.out.println("Example 1: java Main listfactory.ListFactory");
      System.out.println("Example 2: java Main tablefactory.TableFactory");
      System.exit(0);
    }
    // 動的呼び出しにより具体的なfactoryクラス・パッケージに一切依存しない
    Factory factory = Factory.getFactory(args[0]);

    Link asahi = factory.createLink("朝日", "http://www.asahi.com/");
    Link yomiuri = factory.createLink("読売", "http://www.yomiuri.co.jp/");

    Link us_yahoo = factory.createLink("Yahoo!", "http://www.yahoo.com/");
    Link jp_yahoo = factory.createLink("Yahoo!Japan", "http://www.yahoo.co.jp/");
    Link excite = factory.createLink("Excite", "http://www.excite.com/");
    Link google = factory.createLink("Google", "http://www.google.com/");

    Link youtube = factory.createLink("Youtube", "https://www.youtube.com");
    Link niconico = factory.createLink("Niconico", "https://www.nicovideo.jp");

    Tray traynews = factory.createTray("ニュース");
    traynews.add(asahi);
    traynews.add(yomiuri);

    Tray trayyahoo = factory.createTray("Yahoo!");
    trayyahoo.add(us_yahoo);
    trayyahoo.add(jp_yahoo);

    Tray trayVideo = factory.createTray("動画");
    trayVideo.add(youtube);
    trayVideo.add(niconico);

    Tray traysearch = factory.createTray("検索");
    traysearch.add(trayyahoo);
    traysearch.add(trayVideo);
    traysearch.add(excite);
    traysearch.add(google);

    Page page = factory.createPage("LinkPage", "リンクページ");
    page.add(traynews);
    page.add(traysearch);
    page.output();
  }
}
