import java.io.IOException;

public class SaverThread extends Thread {
    private final Data data;
    public SaverThread(String name, Data data) {
        super(name);
        this.data = data;
    }
    public void run() {
        try {
            while (true) {
                data.save();            // データを保存しようとする
                Thread.sleep(1000);     // 約1秒休む
            }
        } catch (IOException e) {
            e.printStackTrace();
        } catch (InterruptedException e) {
            e.printStackTrace();
        }
    }
}
