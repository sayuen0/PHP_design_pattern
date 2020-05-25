public class Main {
    public static void main(String[] args) {
        String s = "BAT";
        String t = s.replace('B', 'C'); // 'B'を'C'に置換
        System.out.println("s = " + s); // replaceを実行した後のs
        System.out.println("t = " + t); // replaceの戻り値t
        if (s == t) {
            System.out.println("s == t");
        } else {
            System.out.println("s != t");
        }
    }
}
