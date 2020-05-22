public class Main {
  public static void main(String[] args) {
    // 重ねないバニラアイス
    IceCream ic1 = new VanillaIceCream();
    System.out.println(ic1.getInfo());
    // 3段重ねバニラ
    IceCream ic2 = new TripleIceCream(new VanillaIceCream());
    System.out.println(ic2.getInfo());
    // ワッフルコーンイチゴ味
    IceCream ic3 = new WaffleCornIceCream(new StrawBerryIceCream());
    System.out.println(ic3.getInfo());
    // 2段重ねワッフルコーンバニラ
    IceCream ic4 = new DoubleIceCream(new WaffleCornIceCream(new VanillaIceCream()));
    System.out.println(ic4.getInfo());
    // チョコチップバニラ
    IceCream ic5 = new ChocoTippedIceCream(new VanillaIceCream());
    System.out.println(ic5.getInfo());
    // めちゃくちゃだけど以下のようなこともできる
    IceCream chaos = new TripleIceCream(
        new DoubleIceCream(new WaffleCornIceCream(new TripleIceCream(new VanillaIceCream()))));
    System.out.println(chaos.getInfo());
  }
}
