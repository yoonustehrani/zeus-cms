import React, { Component } from 'react'
import { Editor } from '@tinymce/tinymce-react';

export default class RichText extends Component {

  state = {
    content: "<p>This is the initial content of the editor</p>"
  }

  handleEditorChange = (content, editor) => {
    this.setState({
        content: content
    })
  }

  render() {
    return (
      <Editor
        initialValue="<p>This is the initial content of the ZeusCms editor</p>"
        init={{
          height: 500,
          menubar: false,
          plugins: [
            'advlist autolink lists link image charmap print preview anchor',
            'searchreplace visualblocks code fullscreen',
            'insertdatetime media table paste code help wordcount'
          ],
          toolbar:
            'undo redo | formatselect | bold italic backcolor | \
            alignleft aligncenter alignright alignjustify | \
            bullist numlist outdent indent | removeformat | help'
        }}
        onEditorChange={this.handleEditorChange}
      />
    );
  }
}