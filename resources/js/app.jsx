import React from "react";
import ReactDOM from "react-dom/client";
import Router from "./router";
import "../css/app.css";
import { useState, useEffect } from "react";

ReactDOM.createRoot(document.getElementById("app")).render(
    <React.StrictMode>
        <Router />
    </React.StrictMode>
);

function App() {
  const [user, setUser] = useState(null);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const token = localStorage.getItem("token");

    if (!token) {
      setLoading(false);
      return;
    }

    fetch("http://localhost:8000/api/me", {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    })
      .then(res => res.json())
      .then(data => {
        setUser(data);
        setLoading(false);
      })
      .catch(() => {
        localStorage.removeItem("token");
        setLoading(false);
      });
  }, []);

  if (loading) return <div>Loading...</div>;

  return (
    <>
      {/* kirim user ke seluruh app */}
    </>
  );
}
