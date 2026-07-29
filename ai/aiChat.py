import streamlit as st
import mtranslate as mt
import os
from google import genai
from PIL import Image

st.set_page_config(
    page_title="ပတ်ဝန်းကျင်ထိန်းသိမ်းရေးပညာရှင် Chatbotဒေါက်တာ Chatbot",
    page_icon="🌿"
)
st.markdown("<h1 style='text-align: center; font-size: 2.5em; font-family: Arial, sans-serif;'>🌿 ပတ်ဝန်းကျင်ထိန်းသိမ်းရေးပညာရှင် Chatbot</h1>", unsafe_allow_html=True)
st.markdown("<h2 style='text-align: center; font-size: 1em; font-family: Arial, sans-serif;'>သင်၏ Virtual Recycling အတိုင်ပင်ခံ</h2>", unsafe_allow_html=True)

if not os.environ.get("GEMINI_API_KEY"):
    st.error("GEMINI_API_KEY is not set. Set it as an environment variable before running this app.")
    st.stop()

client = genai.Client(api_key=os.environ["GEMINI_API_KEY"])

if "messages" not in st.session_state:
    st.session_state.messages = []

file = st.file_uploader("", type=["jpeg", "jpg", "png"])
image = None

if file:
    image = Image.open(file)
    st.image(image, width="stretch")

for message in st.session_state.messages:
    with st.chat_message(message["role"]):
        st.markdown(message["content"])

if prompt := st.chat_input("မင်္ဂလာပါ"):
    st.session_state.messages.append({"role": "user", "content": prompt})
    with st.chat_message("user"):
        st.markdown(prompt)

    with st.chat_message("assistant"):
        with st.spinner('ဆောင်ရွက်နေပါသည်...'):  # Adding a spinner while waiting for the response
            try:
                input_english = mt.translate(prompt, 'en')
                contents = ["You are a kind enviromental expert and speaks in easy to understand language. Ignore the image unless if asked a question about the image. " + input_english]
                if image:
                    contents.append(image)

                response = client.models.generate_content(
                    model="gemini-flash-latest",
                    contents=contents,
                )
                response_burmese = mt.translate(response.text, 'my')
                st.markdown(response_burmese)
                st.session_state.messages.append({"role": "assistant", "content": response_burmese})
            except Exception as e:
                st.error(f"Oops, an error occurred: {str(e)}")
