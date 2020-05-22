import framework.*;
import idcard.*;

public class Main {
    public static void main(String[] args) {
        Factory factory = new IDCardFactory();
        Product card1 = factory.create("User1");
        Product card2 = factory.create("User2");
        Product card3 = factory.create("User3");
        card1.use();
        card2.use();
        card3.use();
    }
}
