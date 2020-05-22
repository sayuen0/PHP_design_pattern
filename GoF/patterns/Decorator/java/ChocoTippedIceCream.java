/**
 * ConcreteDecoratorなアイス チョコトッピング
 */
public class ChocoTippedIceCream extends IceCream {
  private IceCream iceCream;

  public ChocoTippedIceCream(IceCream iceCream) {
    this.iceCream = iceCream;
  }

  public String getInfo() {
    return "チョコチップ" + this.iceCream.getInfo();
  }

}
