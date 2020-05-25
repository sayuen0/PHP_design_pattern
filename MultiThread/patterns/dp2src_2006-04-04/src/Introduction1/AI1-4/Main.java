public class Main {
    public static void main(String[] args) {
        Bank bank = new Bank("A Bad Bank", 1000);   // 1000円の銀行口座を作る
        new ClientThread(bank).start();
        new ClientThread(bank).start();
    }
}
