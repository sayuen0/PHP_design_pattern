/**
 * Concrete Componentなアイスクリーム バニラ味
 */

public class VanillaIceCream extends IceCream {

  @Override
  public String getInfo() {
    return "バニラ味" + super.getInfo();
  }
}
