/**
 * ConcreteDecoratorなアイスクリーム ワッフルコーン
 */
public class WaffleCornIceCream extends IceCream {
  private IceCream iceCream;

  public WaffleCornIceCream(IceCream iceCream) {
    this.iceCream = iceCream;
  }

  public String getInfo() {
    return "ワッフルコーン" + this.iceCream.getInfo();
  }
}
