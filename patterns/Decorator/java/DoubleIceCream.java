/**
 * ConcreteDecoratorなアイスクリーム 2段重ね(全部同じ味)
 */
public class DoubleIceCream extends IceCream {
  private IceCream iceCream;

  public DoubleIceCream(IceCream iceCream) {
    this.iceCream = iceCream;
  }

  @Override
  public String getInfo() {
    return "2段重ね" + this.iceCream.getInfo();
  }
}
