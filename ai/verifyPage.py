from streamlit_javascript import st_javascript
import streamlit as st
import os
import json
from google import genai
from PIL import Image

if not os.environ.get("GEMINI_API_KEY"):
    st.error("GEMINI_API_KEY is not set. Set it as an environment variable before running this app.")
    st.stop()

client = genai.Client(api_key=os.environ["GEMINI_API_KEY"])

MARKERS_JSON = os.path.join("..", "web", "markers.json")

image_fetch = ""
url = ""
extracted_id = None
title = ""
bounty = ""
difficulty = ""
try:
    url = st_javascript("await fetch('').then(r => window.parent.location.href)")
    url = str(url)

    # Example usage
    extracted_id = url.split("id=", 1)[1]
    with open(MARKERS_JSON, 'r') as json_file_fetch:
        data_fetch = json.load(json_file_fetch)
        for feature_fetch in data_fetch["features"]:
            if feature_fetch["properties"]["id"] == str(extracted_id):
                title = feature_fetch["properties"]["title"]
                bounty = feature_fetch["properties"]["bounty"]
                difficulty = feature_fetch["properties"]["difficulty"]
                image_fetch = os.path.join("..", "web", "images", f"{extracted_id}.jpg")

    # Rest of your code...

except Exception as e:
    pass

# Box Style
st.sidebar.markdown("""
<style>
    .box {
        border: 1px solid #e7e7e7;
        background-color: #f9f9f9;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        transition: 0.3s;
    }

    .box:hover {
        box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
    }
</style>
""", unsafe_allow_html=True)

# Marker Information
st.sidebar.markdown(f"""
    <div class="box">
        <b>Title:</b> {title}<br>
        <b>Bounty:</b> {bounty}<br>
        <b>Difficulty:</b> {difficulty}<br>
    </div>
    <br>
""", unsafe_allow_html=True)

# Display Image
try:
    st.sidebar.image(image_fetch, width="stretch")
except st.runtime.media_file_storage.MediaFileStorageError:
    pass

file = st.file_uploader("", type=["jpeg", "jpg", "png"])
image = None

if file:
    image = Image.open(file)

    # display image
    st.image(image, width="stretch")

if st.button("Verify"):
    if not image:
        st.error("Please upload a photo first.")
    elif not extracted_id:
        st.error("Couldn't tell which bounty this is for. Try reopening this page from the map.")
    else:
        with st.spinner(text="Verifying..."):
            try:
                response = client.models.generate_content(
                    model="gemini-flash-latest",
                    contents=["Does the image have trash? Only reply with YES or NO.", image],
                )
                final_response = response.text.strip().upper()

                if final_response.startswith("NO"):
                    # Display a success message
                    st.success("The image is clean!")
                    with open(MARKERS_JSON, 'r') as json_file:
                        data = json.load(json_file)
                    for feature in data["features"]:
                        if feature["properties"]["id"] == str(extracted_id):
                            feature["properties"]["color"] = "grey"
                    with open(MARKERS_JSON, 'w') as json_file:
                        json.dump(data, json_file, indent=4)

                elif final_response.startswith("YES"):
                    # Display an error message
                    st.error("The image is not clean. Please try again!")
                else:
                    st.warning(f"Unexpected response: {final_response}")

            except Exception as e:
                st.error(f"Oops! An error occurred: {str(e)}")
