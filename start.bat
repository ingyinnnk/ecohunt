@echo off
if exist secrets.bat call secrets.bat
cd ai
start cmd /k "streamlit run aiChat.py --server.port 8501"
start cmd /k "streamlit run verifyPage.py --server.port 8502"
