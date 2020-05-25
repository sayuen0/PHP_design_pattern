public class Bank {
    private int money;
    private String name;

    public Bank(String name, int money) {
        this.name = name;
        this.money = money;
    }

    // 同期メソッド。synchronizedしたメソッドはシングルスレッドで動作する
    public synchronized void deposit(int m) {
        money += m;
    }

    public synchronized boolean withdraw(int m) {
        if (money >= m) {
            money -= m;
            return true;
        } else {
            return false;
        }
    }

    public String getName() {
        return name;
    }
}
