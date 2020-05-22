/**
 * ConcreteDecoratorなアイスクリーム ３段重ね(全部同じ味)
 */
public class TripleIceCream extends IceCream {
  private IceCream iceCream;

  public TripleIceCream(IceCream iceCream) {
    this.iceCream = iceCream;
  }

  @Override
  public String getInfo() {
    return "3段重ね" + this.iceCream.getInfo();
  }
}
