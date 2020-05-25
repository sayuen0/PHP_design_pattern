public class ServiceThread extends GracefulThread {
    private int count = 0;

    // 作業中
    @Override
    protected void doWork() throws InterruptedException {
        System.out.print(".");
        Thread.sleep(100);
        count++;
        if (count >= 50) {
            shutdownRequest();  // 自分で終了
        }
    }

    // 終了処理
    @Override
    protected void doShutdown() {
        System.out.println("done.");
    }
}
