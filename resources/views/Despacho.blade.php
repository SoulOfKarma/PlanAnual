<!doctype html>
<html lang="es">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Despacho</title>
        <style>
            /*!
 * Bootstrap v4.1.3 (https://getbootstrap.com/)
 * Copyright 2011-2018 The Bootstrap Authors
 * Copyright 2011-2018 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 */
article,
aside,
figcaption,
figure,
footer,
header,
hgroup,
main,
nav,
section {
    display: block;
}
body {
    margin: 0;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto,
        "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji",
        "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #212529;
    text-align: left;
    background-color: #fff;
}
hr {
    box-sizing: content-box;
    height: 0;
    overflow: visible;
}
h1,
h2,
h3,
h4,
h5,
h6 {
    margin-top: 0;
    margin-bottom: 0.5rem;
}
table {
    border-collapse: collapse;
}
.h1,
.h2,
.h3,
.h4,
.h5,
.h6,
h1,
h2,
h3,
h4,
h5,
h6 {
    margin-bottom: 0.5rem;
    font-family: inherit;
    font-weight: 500;
    line-height: 1.2;
    color: inherit;
}
.h1,
h1 {
    font-size: 2.5rem;
}
.h2,
h2 {
    font-size: 2rem;
}
.h3,
h3 {
    font-size: 1.75rem;
}
.h4,
h4 {
    font-size: 1.5rem;
}
.h5,
h5 {
    font-size: 1.25rem;
}
.h6,
h6 {
    font-size: 0.6rem;
}
.lead {
    font-size: 1.25rem;
    font-weight: 300;
}
.display-1 {
    font-size: 6rem;
    font-weight: 300;
    line-height: 1.2;
}
.display-2 {
    font-size: 5.5rem;
    font-weight: 300;
    line-height: 1.2;
}
.display-3 {
    font-size: 4.5rem;
    font-weight: 300;
    line-height: 1.2;
}
.display-4 {
    font-size: 3.5rem;
    font-weight: 300;
    line-height: 1.2;
}
hr {
    margin-top: 1rem;
    margin-bottom: 1rem;
    border: 0;
    border-top: 1px solid rgba(0, 0, 0, 0.1);
}
.small,
small {
    font-size: 80%;
    font-weight: 400;
}
.mark,
mark {
    padding: 0.2em;
    background-color: #fcf8e3;
}
.list-unstyled {
    padding-left: 0;
    list-style: none;
}
.list-inline {
    padding-left: 0;
    list-style: none;
}
.list-inline-item {
    display: inline-block;
}
.list-inline-item:not(:last-child) {
    margin-right: 0.5rem;
}
.initialism {
    font-size: 90%;
    text-transform: uppercase;
}
.blockquote {
    margin-bottom: 1rem;
    font-size: 1.25rem;
}
.blockquote-footer {
    display: block;
    font-size: 80%;
    color: #6c757d;
}
.blockquote-footer::before {
    content: "\2014 \00A0";
}
.img-fluid {
    max-width: 100%;
    height: auto;
}
.img-thumbnail {
    padding: 0.25rem;
    background-color: #fff;
    border: 1px solid #dee2e6;
    border-radius: 0.25rem;
    max-width: 100%;
    height: auto;
}
.badge-secondary {
    color: #fff;
    background-color: #6c757d;
}
.badge-secondary[href]:focus,
.badge-secondary[href]:hover {
    color: #fff;
    text-decoration: none;
    background-color: #545b62;
}
.figure {
    display: inline-block;
}
.figure-img {
    margin-bottom: 0.5rem;
    line-height: 1;
}
.figure-caption {
    font-size: 90%;
    color: #6c757d;
}
code {
    font-size: 87.5%;
    color: #e83e8c;
    word-break: break-word;
}
a > code {
    color: inherit;
}
kbd {
    padding: 0.2rem 0.4rem;
    font-size: 87.5%;
    color: #fff;
    background-color: #212529;
    border-radius: 0.2rem;
}
kbd kbd {
    padding: 0;
    font-size: 100%;
    font-weight: 700;
}
pre {
    display: block;
    font-size: 87.5%;
    color: #212529;
}
pre code {
    font-size: inherit;
    color: inherit;
    word-break: normal;
}
.pre-scrollable {
    max-height: 340px;
    overflow-y: scroll;
}
.container {
    width: 100%;
    padding-right: 15px;
    padding-left: 15px;
    margin-right: auto;
    margin-left: auto;
}
@media (min-width: 576px) {
    .container {
        max-width: 540px;
    }
}
@media (min-width: 768px) {
    .container {
        max-width: 720px;
    }
}
@media (min-width: 992px) {
    .container {
        max-width: 960px;
    }
}
@media (min-width: 1200px) {
    .container {
        max-width: 1140px;
    }
}
.container-fluid {
    width: 100%;
    padding-right: 15px;
    padding-left: 15px;
    margin-right: auto;
    margin-left: auto;
}
.row {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    margin-right: -15px;
    margin-left: -15px;
}
.no-gutters {
    margin-right: 0;
    margin-left: 0;
}
.no-gutters > .col,
.no-gutters > [class*="col-"] {
    padding-right: 0;
    padding-left: 0;
}
.col,
.col-1,
.col-10,
.col-11,
.col-12,
.col-2,
.col-3,
.col-4,
.col-5,
.col-6,
.col-7,
.col-8,
.col-9,
.col-auto,
.col-lg,
.col-lg-1,
.col-lg-10,
.col-lg-11,
.col-lg-12,
.col-lg-2,
.col-lg-3,
.col-lg-4,
.col-lg-5,
.col-lg-6,
.col-lg-7,
.col-lg-8,
.col-lg-9,
.col-lg-auto,
.col-md,
.col-md-1,
.col-md-10,
.col-md-11,
.col-md-12,
.col-md-2,
.col-md-3,
.col-md-4,
.col-md-5,
.col-md-6,
.col-md-7,
.col-md-8,
.col-md-9,
.col-md-auto,
.col-sm,
.col-sm-1,
.col-sm-10,
.col-sm-11,
.col-sm-12,
.col-sm-2,
.col-sm-3,
.col-sm-4,
.col-sm-5,
.col-sm-6,
.col-sm-7,
.col-sm-8,
.col-sm-9,
.col-sm-auto,
.col-xl,
.col-xl-1,
.col-xl-10,
.col-xl-11,
.col-xl-12,
.col-xl-2,
.col-xl-3,
.col-xl-4,
.col-xl-5,
.col-xl-6,
.col-xl-7,
.col-xl-8,
.col-xl-9,
.col-xl-auto {
    position: relative;
    width: 100%;
    min-height: 1px;
    padding-right: 15px;
    padding-left: 15px;
}
.col {
    -ms-flex-preferred-size: 0;
    flex-basis: 0;
    -ms-flex-positive: 1;
    flex-grow: 1;
    max-width: 100%;
}
.col-auto {
    -ms-flex: 0 0 auto;
    flex: 0 0 auto;
    width: auto;
    max-width: none;
}
.col-1 {
    -ms-flex: 0 0 8.333333%;
    flex: 0 0 8.333333%;
    max-width: 8.333333%;
}
.col-2 {
    -ms-flex: 0 0 16.666667%;
    flex: 0 0 16.666667%;
    max-width: 16.666667%;
}
.col-3 {
    -ms-flex: 0 0 25%;
    flex: 0 0 25%;
    max-width: 25%;
}
.col-4 {
    -ms-flex: 0 0 33.333333%;
    flex: 0 0 33.333333%;
    max-width: 33.333333%;
}
.col-5 {
    -ms-flex: 0 0 41.666667%;
    flex: 0 0 41.666667%;
    max-width: 41.666667%;
}
.col-6 {
    -ms-flex: 0 0 50%;
    flex: 0 0 50%;
    max-width: 50%;
}
.col-7 {
    -ms-flex: 0 0 58.333333%;
    flex: 0 0 58.333333%;
    max-width: 58.333333%;
}
.col-8 {
    -ms-flex: 0 0 66.666667%;
    flex: 0 0 66.666667%;
    max-width: 66.666667%;
}
.col-9 {
    -ms-flex: 0 0 75%;
    flex: 0 0 75%;
    max-width: 75%;
}
.col-10 {
    -ms-flex: 0 0 83.333333%;
    flex: 0 0 83.333333%;
    max-width: 83.333333%;
}
.col-11 {
    -ms-flex: 0 0 91.666667%;
    flex: 0 0 91.666667%;
    max-width: 91.666667%;
}
.col-12 {
    -ms-flex: 0 0 100%;
    flex: 0 0 100%;
    max-width: 100%;
}
.order-first {
    -ms-flex-order: -1;
    order: -1;
}
.order-last {
    -ms-flex-order: 13;
    order: 13;
}
.order-0 {
    -ms-flex-order: 0;
    order: 0;
}
.order-1 {
    -ms-flex-order: 1;
    order: 1;
}
.order-2 {
    -ms-flex-order: 2;
    order: 2;
}
.order-3 {
    -ms-flex-order: 3;
    order: 3;
}
.order-4 {
    -ms-flex-order: 4;
    order: 4;
}
.order-5 {
    -ms-flex-order: 5;
    order: 5;
}
.order-6 {
    -ms-flex-order: 6;
    order: 6;
}
.order-7 {
    -ms-flex-order: 7;
    order: 7;
}
.order-8 {
    -ms-flex-order: 8;
    order: 8;
}
.order-9 {
    -ms-flex-order: 9;
    order: 9;
}
.order-10 {
    -ms-flex-order: 10;
    order: 10;
}
.order-11 {
    -ms-flex-order: 11;
    order: 11;
}
.order-12 {
    -ms-flex-order: 12;
    order: 12;
}
.offset-1 {
    margin-left: 8.333333%;
}
.offset-2 {
    margin-left: 16.666667%;
}
.offset-3 {
    margin-left: 25%;
}
.offset-4 {
    margin-left: 33.333333%;
}
.offset-5 {
    margin-left: 41.666667%;
}
.offset-6 {
    margin-left: 50%;
}
.offset-7 {
    margin-left: 58.333333%;
}
.offset-8 {
    margin-left: 66.666667%;
}
.offset-9 {
    margin-left: 75%;
}
.offset-10 {
    margin-left: 83.333333%;
}
.offset-11 {
    margin-left: 91.666667%;
}
@media (min-width: 576px) {
    .col-sm {
        -ms-flex-preferred-size: 0;
        flex-basis: 0;
        -ms-flex-positive: 1;
        flex-grow: 1;
        max-width: 100%;
    }
    .col-sm-auto {
        -ms-flex: 0 0 auto;
        flex: 0 0 auto;
        width: auto;
        max-width: none;
    }
    .col-sm-1 {
        -ms-flex: 0 0 8.333333%;
        flex: 0 0 8.333333%;
        max-width: 8.333333%;
    }
    .col-sm-2 {
        -ms-flex: 0 0 16.666667%;
        flex: 0 0 16.666667%;
        max-width: 16.666667%;
    }
    .col-sm-3 {
        -ms-flex: 0 0 25%;
        flex: 0 0 25%;
        max-width: 25%;
    }
    .col-sm-4 {
        -ms-flex: 0 0 33.333333%;
        flex: 0 0 33.333333%;
        max-width: 33.333333%;
    }
    .col-sm-5 {
        -ms-flex: 0 0 41.666667%;
        flex: 0 0 41.666667%;
        max-width: 41.666667%;
    }
    .col-sm-6 {
        -ms-flex: 0 0 50%;
        flex: 0 0 50%;
        max-width: 50%;
    }
    .col-sm-7 {
        -ms-flex: 0 0 58.333333%;
        flex: 0 0 58.333333%;
        max-width: 58.333333%;
    }
    .col-sm-8 {
        -ms-flex: 0 0 66.666667%;
        flex: 0 0 66.666667%;
        max-width: 66.666667%;
    }
    .col-sm-9 {
        -ms-flex: 0 0 75%;
        flex: 0 0 75%;
        max-width: 75%;
    }
    .col-sm-10 {
        -ms-flex: 0 0 83.333333%;
        flex: 0 0 83.333333%;
        max-width: 83.333333%;
    }
    .col-sm-11 {
        -ms-flex: 0 0 91.666667%;
        flex: 0 0 91.666667%;
        max-width: 91.666667%;
    }
    .col-sm-12 {
        -ms-flex: 0 0 100%;
        flex: 0 0 100%;
        max-width: 100%;
    }
    .order-sm-first {
        -ms-flex-order: -1;
        order: -1;
    }
    .order-sm-last {
        -ms-flex-order: 13;
        order: 13;
    }
    .order-sm-0 {
        -ms-flex-order: 0;
        order: 0;
    }
    .order-sm-1 {
        -ms-flex-order: 1;
        order: 1;
    }
    .order-sm-2 {
        -ms-flex-order: 2;
        order: 2;
    }
    .order-sm-3 {
        -ms-flex-order: 3;
        order: 3;
    }
    .order-sm-4 {
        -ms-flex-order: 4;
        order: 4;
    }
    .order-sm-5 {
        -ms-flex-order: 5;
        order: 5;
    }
    .order-sm-6 {
        -ms-flex-order: 6;
        order: 6;
    }
    .order-sm-7 {
        -ms-flex-order: 7;
        order: 7;
    }
    .order-sm-8 {
        -ms-flex-order: 8;
        order: 8;
    }
    .order-sm-9 {
        -ms-flex-order: 9;
        order: 9;
    }
    .order-sm-10 {
        -ms-flex-order: 10;
        order: 10;
    }
    .order-sm-11 {
        -ms-flex-order: 11;
        order: 11;
    }
    .order-sm-12 {
        -ms-flex-order: 12;
        order: 12;
    }
    .offset-sm-0 {
        margin-left: 0;
    }
    .offset-sm-1 {
        margin-left: 8.333333%;
    }
    .offset-sm-2 {
        margin-left: 16.666667%;
    }
    .offset-sm-3 {
        margin-left: 25%;
    }
    .offset-sm-4 {
        margin-left: 33.333333%;
    }
    .offset-sm-5 {
        margin-left: 41.666667%;
    }
    .offset-sm-6 {
        margin-left: 50%;
    }
    .offset-sm-7 {
        margin-left: 58.333333%;
    }
    .offset-sm-8 {
        margin-left: 66.666667%;
    }
    .offset-sm-9 {
        margin-left: 75%;
    }
    .offset-sm-10 {
        margin-left: 83.333333%;
    }
    .offset-sm-11 {
        margin-left: 91.666667%;
    }
}
@media (min-width: 768px) {
    .col-md {
        -ms-flex-preferred-size: 0;
        flex-basis: 0;
        -ms-flex-positive: 1;
        flex-grow: 1;
        max-width: 100%;
    }
    .col-md-auto {
        -ms-flex: 0 0 auto;
        flex: 0 0 auto;
        width: auto;
        max-width: none;
    }
    .col-md-1 {
        -ms-flex: 0 0 8.333333%;
        flex: 0 0 8.333333%;
        max-width: 8.333333%;
    }
    .col-md-2 {
        -ms-flex: 0 0 16.666667%;
        flex: 0 0 16.666667%;
        max-width: 16.666667%;
    }
    .col-md-3 {
        -ms-flex: 0 0 25%;
        flex: 0 0 25%;
        max-width: 25%;
    }
    .col-md-4 {
        -ms-flex: 0 0 33.333333%;
        flex: 0 0 33.333333%;
        max-width: 33.333333%;
    }
    .col-md-5 {
        -ms-flex: 0 0 41.666667%;
        flex: 0 0 41.666667%;
        max-width: 41.666667%;
    }
    .col-md-6 {
        -ms-flex: 0 0 50%;
        flex: 0 0 50%;
        max-width: 50%;
    }
    .col-md-7 {
        -ms-flex: 0 0 58.333333%;
        flex: 0 0 58.333333%;
        max-width: 58.333333%;
    }
    .col-md-8 {
        -ms-flex: 0 0 66.666667%;
        flex: 0 0 66.666667%;
        max-width: 66.666667%;
    }
    .col-md-9 {
        -ms-flex: 0 0 75%;
        flex: 0 0 75%;
        max-width: 75%;
    }
    .col-md-10 {
        -ms-flex: 0 0 83.333333%;
        flex: 0 0 83.333333%;
        max-width: 83.333333%;
    }
    .col-md-11 {
        -ms-flex: 0 0 91.666667%;
        flex: 0 0 91.666667%;
        max-width: 91.666667%;
    }
    .col-md-12 {
        -ms-flex: 0 0 100%;
        flex: 0 0 100%;
        max-width: 100%;
    }
    .order-md-first {
        -ms-flex-order: -1;
        order: -1;
    }
    .order-md-last {
        -ms-flex-order: 13;
        order: 13;
    }
    .order-md-0 {
        -ms-flex-order: 0;
        order: 0;
    }
    .order-md-1 {
        -ms-flex-order: 1;
        order: 1;
    }
    .order-md-2 {
        -ms-flex-order: 2;
        order: 2;
    }
    .order-md-3 {
        -ms-flex-order: 3;
        order: 3;
    }
    .order-md-4 {
        -ms-flex-order: 4;
        order: 4;
    }
    .order-md-5 {
        -ms-flex-order: 5;
        order: 5;
    }
    .order-md-6 {
        -ms-flex-order: 6;
        order: 6;
    }
    .order-md-7 {
        -ms-flex-order: 7;
        order: 7;
    }
    .order-md-8 {
        -ms-flex-order: 8;
        order: 8;
    }
    .order-md-9 {
        -ms-flex-order: 9;
        order: 9;
    }
    .order-md-10 {
        -ms-flex-order: 10;
        order: 10;
    }
    .order-md-11 {
        -ms-flex-order: 11;
        order: 11;
    }
    .order-md-12 {
        -ms-flex-order: 12;
        order: 12;
    }
    .offset-md-0 {
        margin-left: 0;
    }
    .offset-md-1 {
        margin-left: 8.333333%;
    }
    .offset-md-2 {
        margin-left: 16.666667%;
    }
    .offset-md-3 {
        margin-left: 25%;
    }
    .offset-md-4 {
        margin-left: 33.333333%;
    }
    .offset-md-5 {
        margin-left: 41.666667%;
    }
    .offset-md-6 {
        margin-left: 50%;
    }
    .offset-md-7 {
        margin-left: 58.333333%;
    }
    .offset-md-8 {
        margin-left: 66.666667%;
    }
    .offset-md-9 {
        margin-left: 75%;
    }
    .offset-md-10 {
        margin-left: 83.333333%;
    }
    .offset-md-11 {
        margin-left: 91.666667%;
    }
}
@media (min-width: 992px) {
    .col-lg {
        -ms-flex-preferred-size: 0;
        flex-basis: 0;
        -ms-flex-positive: 1;
        flex-grow: 1;
        max-width: 100%;
    }
    .col-lg-auto {
        -ms-flex: 0 0 auto;
        flex: 0 0 auto;
        width: auto;
        max-width: none;
    }
    .col-lg-1 {
        -ms-flex: 0 0 8.333333%;
        flex: 0 0 8.333333%;
        max-width: 8.333333%;
    }
    .col-lg-2 {
        -ms-flex: 0 0 16.666667%;
        flex: 0 0 16.666667%;
        max-width: 16.666667%;
    }
    .col-lg-3 {
        -ms-flex: 0 0 25%;
        flex: 0 0 25%;
        max-width: 25%;
    }
    .col-lg-4 {
        -ms-flex: 0 0 33.333333%;
        flex: 0 0 33.333333%;
        max-width: 33.333333%;
    }
    .col-lg-5 {
        -ms-flex: 0 0 41.666667%;
        flex: 0 0 41.666667%;
        max-width: 41.666667%;
    }
    .col-lg-6 {
        -ms-flex: 0 0 50%;
        flex: 0 0 50%;
        max-width: 50%;
    }
    .col-lg-7 {
        -ms-flex: 0 0 58.333333%;
        flex: 0 0 58.333333%;
        max-width: 58.333333%;
    }
    .col-lg-8 {
        -ms-flex: 0 0 66.666667%;
        flex: 0 0 66.666667%;
        max-width: 66.666667%;
    }
    .col-lg-9 {
        -ms-flex: 0 0 75%;
        flex: 0 0 75%;
        max-width: 75%;
    }
    .col-lg-10 {
        -ms-flex: 0 0 83.333333%;
        flex: 0 0 83.333333%;
        max-width: 83.333333%;
    }
    .col-lg-11 {
        -ms-flex: 0 0 91.666667%;
        flex: 0 0 91.666667%;
        max-width: 91.666667%;
    }
    .col-lg-12 {
        -ms-flex: 0 0 100%;
        flex: 0 0 100%;
        max-width: 100%;
    }
    .order-lg-first {
        -ms-flex-order: -1;
        order: -1;
    }
    .order-lg-last {
        -ms-flex-order: 13;
        order: 13;
    }
    .order-lg-0 {
        -ms-flex-order: 0;
        order: 0;
    }
    .order-lg-1 {
        -ms-flex-order: 1;
        order: 1;
    }
    .order-lg-2 {
        -ms-flex-order: 2;
        order: 2;
    }
    .order-lg-3 {
        -ms-flex-order: 3;
        order: 3;
    }
    .order-lg-4 {
        -ms-flex-order: 4;
        order: 4;
    }
    .order-lg-5 {
        -ms-flex-order: 5;
        order: 5;
    }
    .order-lg-6 {
        -ms-flex-order: 6;
        order: 6;
    }
    .order-lg-7 {
        -ms-flex-order: 7;
        order: 7;
    }
    .order-lg-8 {
        -ms-flex-order: 8;
        order: 8;
    }
    .order-lg-9 {
        -ms-flex-order: 9;
        order: 9;
    }
    .order-lg-10 {
        -ms-flex-order: 10;
        order: 10;
    }
    .order-lg-11 {
        -ms-flex-order: 11;
        order: 11;
    }
    .order-lg-12 {
        -ms-flex-order: 12;
        order: 12;
    }
    .offset-lg-0 {
        margin-left: 0;
    }
    .offset-lg-1 {
        margin-left: 8.333333%;
    }
    .offset-lg-2 {
        margin-left: 16.666667%;
    }
    .offset-lg-3 {
        margin-left: 25%;
    }
    .offset-lg-4 {
        margin-left: 33.333333%;
    }
    .offset-lg-5 {
        margin-left: 41.666667%;
    }
    .offset-lg-6 {
        margin-left: 50%;
    }
    .offset-lg-7 {
        margin-left: 58.333333%;
    }
    .offset-lg-8 {
        margin-left: 66.666667%;
    }
    .offset-lg-9 {
        margin-left: 75%;
    }
    .offset-lg-10 {
        margin-left: 83.333333%;
    }
    .offset-lg-11 {
        margin-left: 91.666667%;
    }
}
@media (min-width: 1200px) {
    .col-xl {
        -ms-flex-preferred-size: 0;
        flex-basis: 0;
        -ms-flex-positive: 1;
        flex-grow: 1;
        max-width: 100%;
    }
    .col-xl-auto {
        -ms-flex: 0 0 auto;
        flex: 0 0 auto;
        width: auto;
        max-width: none;
    }
    .col-xl-1 {
        -ms-flex: 0 0 8.333333%;
        flex: 0 0 8.333333%;
        max-width: 8.333333%;
    }
    .col-xl-2 {
        -ms-flex: 0 0 16.666667%;
        flex: 0 0 16.666667%;
        max-width: 16.666667%;
    }
    .col-xl-3 {
        -ms-flex: 0 0 25%;
        flex: 0 0 25%;
        max-width: 25%;
    }
    .col-xl-4 {
        -ms-flex: 0 0 33.333333%;
        flex: 0 0 33.333333%;
        max-width: 33.333333%;
    }
    .col-xl-5 {
        -ms-flex: 0 0 41.666667%;
        flex: 0 0 41.666667%;
        max-width: 41.666667%;
    }
    .col-xl-6 {
        -ms-flex: 0 0 50%;
        flex: 0 0 50%;
        max-width: 50%;
    }
    .col-xl-7 {
        -ms-flex: 0 0 58.333333%;
        flex: 0 0 58.333333%;
        max-width: 58.333333%;
    }
    .col-xl-8 {
        -ms-flex: 0 0 66.666667%;
        flex: 0 0 66.666667%;
        max-width: 66.666667%;
    }
    .col-xl-9 {
        -ms-flex: 0 0 75%;
        flex: 0 0 75%;
        max-width: 75%;
    }
    .col-xl-10 {
        -ms-flex: 0 0 83.333333%;
        flex: 0 0 83.333333%;
        max-width: 83.333333%;
    }
    .col-xl-11 {
        -ms-flex: 0 0 91.666667%;
        flex: 0 0 91.666667%;
        max-width: 91.666667%;
    }
    .col-xl-12 {
        -ms-flex: 0 0 100%;
        flex: 0 0 100%;
        max-width: 100%;
    }
    .order-xl-first {
        -ms-flex-order: -1;
        order: -1;
    }
    .order-xl-last {
        -ms-flex-order: 13;
        order: 13;
    }
    .order-xl-0 {
        -ms-flex-order: 0;
        order: 0;
    }
    .order-xl-1 {
        -ms-flex-order: 1;
        order: 1;
    }
    .order-xl-2 {
        -ms-flex-order: 2;
        order: 2;
    }
    .order-xl-3 {
        -ms-flex-order: 3;
        order: 3;
    }
    .order-xl-4 {
        -ms-flex-order: 4;
        order: 4;
    }
    .order-xl-5 {
        -ms-flex-order: 5;
        order: 5;
    }
    .order-xl-6 {
        -ms-flex-order: 6;
        order: 6;
    }
    .order-xl-7 {
        -ms-flex-order: 7;
        order: 7;
    }
    .order-xl-8 {
        -ms-flex-order: 8;
        order: 8;
    }
    .order-xl-9 {
        -ms-flex-order: 9;
        order: 9;
    }
    .order-xl-10 {
        -ms-flex-order: 10;
        order: 10;
    }
    .order-xl-11 {
        -ms-flex-order: 11;
        order: 11;
    }
    .order-xl-12 {
        -ms-flex-order: 12;
        order: 12;
    }
    .offset-xl-0 {
        margin-left: 0;
    }
    .offset-xl-1 {
        margin-left: 8.333333%;
    }
    .offset-xl-2 {
        margin-left: 16.666667%;
    }
    .offset-xl-3 {
        margin-left: 25%;
    }
    .offset-xl-4 {
        margin-left: 33.333333%;
    }
    .offset-xl-5 {
        margin-left: 41.666667%;
    }
    .offset-xl-6 {
        margin-left: 50%;
    }
    .offset-xl-7 {
        margin-left: 58.333333%;
    }
    .offset-xl-8 {
        margin-left: 66.666667%;
    }
    .offset-xl-9 {
        margin-left: 75%;
    }
    .offset-xl-10 {
        margin-left: 83.333333%;
    }
    .offset-xl-11 {
        margin-left: 91.666667%;
    }
}
.table {
    width: 100%;
    margin-bottom: 1rem;
    background-color: transparent;
}
.table td,
.table th {
    padding: 0.75rem;
    vertical-align: top;
    border-top: 1px solid #dee2e6;
}
.table thead th {
    vertical-align: bottom;
    border-bottom: 2px solid #dee2e6;
}
.table tbody + tbody {
    border-top: 2px solid #dee2e6;
}
.table .table {
    background-color: #fff;
}
.table-sm td,
.table-sm th {
    padding: 0.3rem;
}
.table-bordered {
    border: 1px solid #dee2e6;
}
.table-bordered td,
.table-bordered th {
    border: 1px solid #dee2e6;
}
.table-bordered thead td,
.table-bordered thead th {
    border-bottom-width: 2px;
}
.table-borderless tbody + tbody,
.table-borderless td,
.table-borderless th,
.table-borderless thead th {
    border: 0;
}
.table-striped tbody tr:nth-of-type(odd) {
    background-color: rgba(0, 0, 0, 0.05);
}
.table-hover tbody tr:hover {
    background-color: rgba(0, 0, 0, 0.075);
}
.table-primary,
.table-primary > td,
.table-primary > th {
    background-color: #b8daff;
}
.table-hover .table-primary:hover {
    background-color: #9fcdff;
}
.table-hover .table-primary:hover > td,
.table-hover .table-primary:hover > th {
    background-color: #9fcdff;
}
.table-secondary,
.table-secondary > td,
.table-secondary > th {
    background-color: #d6d8db;
}
.table-hover .table-secondary:hover {
    background-color: #c8cbcf;
}
.table-hover .table-secondary:hover > td,
.table-hover .table-secondary:hover > th {
    background-color: #c8cbcf;
}
.table-success,
.table-success > td,
.table-success > th {
    background-color: #c3e6cb;
}
.table-hover .table-success:hover {
    background-color: #b1dfbb;
}
.table-hover .table-success:hover > td,
.table-hover .table-success:hover > th {
    background-color: #b1dfbb;
}
.table-info,
.table-info > td,
.table-info > th {
    background-color: #bee5eb;
}
.table-hover .table-info:hover {
    background-color: #abdde5;
}
.table-hover .table-info:hover > td,
.table-hover .table-info:hover > th {
    background-color: #abdde5;
}
.table-warning,
.table-warning > td,
.table-warning > th {
    background-color: #ffeeba;
}
.table-hover .table-warning:hover {
    background-color: #ffe8a1;
}
.table-hover .table-warning:hover > td,
.table-hover .table-warning:hover > th {
    background-color: #ffe8a1;
}
.table-danger,
.table-danger > td,
.table-danger > th {
    background-color: #f5c6cb;
}
.table-hover .table-danger:hover {
    background-color: #f1b0b7;
}
.table-hover .table-danger:hover > td,
.table-hover .table-danger:hover > th {
    background-color: #f1b0b7;
}
.table-light,
.table-light > td,
.table-light > th {
    background-color: #fdfdfe;
}
.table-hover .table-light:hover {
    background-color: #ececf6;
}
.table-hover .table-light:hover > td,
.table-hover .table-light:hover > th {
    background-color: #ececf6;
}
.table-dark,
.table-dark > td,
.table-dark > th {
    background-color: #c6c8ca;
}
.table-hover .table-dark:hover {
    background-color: #b9bbbe;
}
.table-hover .table-dark:hover > td,
.table-hover .table-dark:hover > th {
    background-color: #b9bbbe;
}
.table-active,
.table-active > td,
.table-active > th {
    background-color: rgba(0, 0, 0, 0.075);
}
.table-hover .table-active:hover {
    background-color: rgba(0, 0, 0, 0.075);
}
.table-hover .table-active:hover > td,
.table-hover .table-active:hover > th {
    background-color: rgba(0, 0, 0, 0.075);
}
.table .thead-dark th {
    color: #fff;
    background-color: #212529;
    border-color: #32383e;
}
.table .thead-light th {
    color: #495057;
    background-color: #e9ecef;
    border-color: #dee2e6;
}
.table-dark {
    color: #fff;
    background-color: #212529;
}
.table-dark td,
.table-dark th,
.table-dark thead th {
    border-color: #32383e;
}
.table-dark.table-bordered {
    border: 0;
}
.table-dark.table-striped tbody tr:nth-of-type(odd) {
    background-color: rgba(255, 255, 255, 0.05);
}
.table-dark.table-hover tbody tr:hover {
    background-color: rgba(255, 255, 255, 0.075);
}
@media (max-width: 575.98px) {
    .table-responsive-sm {
        display: block;
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        -ms-overflow-style: -ms-autohiding-scrollbar;
    }
    .table-responsive-sm > .table-bordered {
        border: 0;
    }
}
@media (max-width: 767.98px) {
    .table-responsive-md {
        display: block;
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        -ms-overflow-style: -ms-autohiding-scrollbar;
    }
    .table-responsive-md > .table-bordered {
        border: 0;
    }
}
@media (max-width: 991.98px) {
    .table-responsive-lg {
        display: block;
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        -ms-overflow-style: -ms-autohiding-scrollbar;
    }
    .table-responsive-lg > .table-bordered {
        border: 0;
    }
}
@media (max-width: 1199.98px) {
    .table-responsive-xl {
        display: block;
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        -ms-overflow-style: -ms-autohiding-scrollbar;
    }
    .table-responsive-xl > .table-bordered {
        border: 0;
    }
}
.table-responsive {
    display: block;
    width: 100%;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
    -ms-overflow-style: -ms-autohiding-scrollbar;
}
.table-responsive > .table-bordered {
    border: 0;
}
.align-baseline {
    vertical-align: baseline !important;
}
.align-top {
    vertical-align: top !important;
}
.align-middle {
    vertical-align: middle !important;
}
.align-bottom {
    vertical-align: bottom !important;
}
.align-text-bottom {
    vertical-align: text-bottom !important;
}
.align-text-top {
    vertical-align: text-top !important;
}
.bg-primary {
    background-color: #007bff !important;
}
#OrdenTabla{
  text-align: center;
  max-height: 200px !important;
  height: 200px !important;
}
        </style>
    </head>
              @php
              $fechaSistema = "";
              $fechaDespacho = "";
              $total = 0;
              $observacion = "";
              $nfolio = "";
              $descripcionServicio = "";
              $nlibropedido = "";
              @endphp
              
              @foreach ($getRec as $dato)
              <?php
                 $fechaSistema = $dato['FECSYS'];
                 $fechaDespacho = $dato['FECDES'];
                 $observacion = $dato['OBS'];
                 $nfolio = $dato['FOLIO'];
                 $descripcionServicio = $dato['descripcionServicio'];
                 $nlibropedido = $dato['NUMLIBRO'];
              ?>
              @endforeach

              @foreach ($getDet as $da)
              <?php
              $total = $total + $da['VALORTOTALDESP'];
              ?>
                @endforeach   

    <body>
        <div class="container-fluid">
            <div class="row">
                <table class="table table-borderless table-sm">
                    <tbody>
                      <tr>
                        <td><img src="http://10.5.23.248:9000/Documentos/users/Documentacion/1.jpg"></td>
                        <td style="text-align: center;  width: 500px;"><b>Folio Despacho </b>
                            <b>N° {{$nfolio}}</b><br>
                            <h4>DESPACHO PEDIDOS</h4>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
               </table>     
            </div>
            <div class="row table-responsive-xl">
              <table class="table table-bordered table-sm">
               <tbody>
                 <tr>
                   <td class="badge badge-secondary"><h6>Fecha Sistema</h6></td>
                   <td class="badge badge-secondary"><h6>Fecha Despacho</h6></td>
                   <td class="badge badge-secondary"><h6>Servicio</h6></td>
                    <td class="badge badge-secondary"><h6>N° Libro Pedido</h6></td>
                 </tr>
                 <tr>
                  <td><h6>{{$fechaSistema}}</h6></td>
                   <td><h6>{{$fechaDespacho}}</h6></td>
                   <td><h6>{{$descripcionServicio}}</h6></td>
                   <td><h6>{{$nlibropedido}}</h6></td>
                 </tr>
               </tbody>
              </table>
            </div>
            
            <div class="row table-responsive-xl">
              <table class="table table-bordered table-sm">
              <tbody>
                 <tr>
                   <td class="badge badge-secondary" style="width: 7.33%"><h6>Codigo Interno</h6></td>
                   <td class="badge badge-secondary" style="width: 10.33%"><h6>Codigo Barra</h6></td>
                   <td class="badge badge-secondary"><h6>Descripcion</h6></td>
                   <td class="badge badge-secondary" style="width: 5.33%"><h6>Unidad Medida</h6></td>                   
                   <td class="badge badge-secondary" style="width: 5.33%"><h6>Precio Unitario</h6></td>
                   <td class="badge badge-secondary" style="width: 8.33%"><h6>Fecha Vencimiento</h6></td>
                   <td class="badge badge-secondary" style="width: 8.33%"><h6>Lote</h6></td>
                   <td class="badge badge-secondary" style="width: 8.33%"><h6>Cantidad Despachada</h6></td>
                   <td class="badge badge-secondary" style="width: 10.33%"><h6>Total</h6></td>
                   
                 </tr>
                 @foreach ($getDet as $dat)
                
                 <tr>
                   <td><h6><?php echo $dat['CODART'] ?></h6></td>
                   <td><h6><?php echo $dat['CODBAR'] ?></h6></td>
                   <td><h6><?php echo $dat['NOMART'] ?></h6></td>
                   <td><h6><?php echo $dat['UNIMED'] ?></h6></td>                   
                   <td><h6><?php echo $dat['PRECIO'] ?></h6></td>                   
                   <td><h6><?php echo $dat['FECVEN'] ?></h6></td>
                   <td><h6><?php echo $dat['LOTE'] ?></h6></td>
                   <td><h6><?php echo $dat['CANTIDAD'] ?></h6></td>
                   <td><h6><?php echo $dat['VALORTOTALDESP'] ?></h6></td>
                 </tr>
                
                @endforeach   
               </tbody>
              </table>
            </div>

            <div class="row table-responsive-xl">
              <table class="table table-bordered table-sm">
               <tbody>
                <tr>
                 <td class="badge badge-secondary" style="width: 8%"><h6>Observaciones</h6></td>
                 <td class="badge badge-secondary" style="width: 2%"><h6>Total Despacho</h6></td>
                  </tr>
                  <tr>
                      <td style="height: 5.33%"><h6>{{$observacion}}</h6></td>
                      <td style="height: 5.33%"><h6>{{$total}}</h6></td>
                     </tr>
               </tbody>
              </table>
            </div>

            <div class="row table-responsive-xl">
              <table class="table table-bordered table-sm">
               <tbody>
                <tr id="OrdenTabla">
                  <td style="height: 7.33%"><h6 ></h6></td>
                  <td style="height: 7.33%"><h6></h6></td>
                  <td style="height: 7.33%"><h6></h6></td>
                </tr>
                <tr>
                 <td class="badge badge-secondary"><h6>Encargado Seccion Bodega</h6></td>
                 <td class="badge badge-secondary"><h6>Jefe Bodega</h6></td>
                 <td class="badge badge-secondary"><h6>Nombre y Firma Autorizado Para Retirar</h6></td>                 
                </tr>
               </tbody>
              </table>
            </div>          
        </div>
        
    </body>
   
</html>