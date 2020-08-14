import React, { Component } from 'react';
import ReactDom from 'react-dom';
import RichText from './components/RichText';

let target = document.getElementById("react-richtext");

if(target) {
    ReactDom.render(<RichText/>, target)
}