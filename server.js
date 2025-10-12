// server.js
const express = require("express");
const app = express();
const http = require("http").createServer(app);
const io = require("socket.io")(http, {
  cors: {
    origin: "*", // Cho phép tất cả domain (hoặc bạn có thể giới hạn)
  },
});

io.on("connection", (socket) => {
  console.log("🔌 Một client vừa kết nối");
});

// Khi PHP gọi URL này, nó sẽ gửi thông điệp đến tất cả client đang kết nối
app.get("/new-order", (req, res) => {
  const orderMsg = req.query.order || "Có đơn hàng mới!";
  io.emit("new-order", orderMsg);
  console.log("📦 Thông báo gửi:", orderMsg);
  res.send("Đã gửi thông báo tới client!");
});

http.listen(3001, () => {
  console.log("🚀 Socket server chạy tại http://localhost:3001");
});

