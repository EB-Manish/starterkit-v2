const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const BrowserSyncPlugin = require("browser-sync-webpack-plugin");
const TerserPlugin = require("terser-webpack-plugin");
const CssMinimizerPlugin = require("css-minimizer-webpack-plugin");


var jQuery = require("jquery");
var webpack = require("webpack");

var path = require("path");

// change these variables to fit your project
const jsPath = "./assets/js";
const cssPath = "./assets/scss";
const outputPath = "./assets/dist";
const localDomain = "http://localhost:8888/starter-kit";
const entryPoints = {
  // 'app' is the output name, people commonly use 'bundle'
  // you can have more than 1 entry point
  app: jsPath + "/app.js",
  //   'style': cssPath + '/style.scss',
};

module.exports = {
  resolve: {
    alias: {
      jquery: "jquery/src/jquery",
    },
  },
  entry: entryPoints,
  output: {
    path: path.resolve(__dirname, outputPath),
    filename: "[name].js",
  },
  devtool: "source-map",
  optimization: {
    minimize: true,
    minimizer: [new TerserPlugin(), new CssMinimizerPlugin()],
  },
  plugins: [
    new MiniCssExtractPlugin({
      //   filename: '../../[name].css',
      filename: "../../style.css",
    }),

    // Uncomment this if you want to use CSS Live reload
    new BrowserSyncPlugin(
      {
        proxy: localDomain,
        // files: [ outputPath + '/*.css' ],
        files: ["./*.css", outputPath + "/*.js"],
        injectCss: true,
      },
      { reload: false }
    ),

    new webpack.ProvidePlugin({
      $: "jquery",
      jQuery: "jquery",
    })
  ],
  module: {
    rules: [
      {
        test: /\.s[ac]ss$/i,
        use: [
          MiniCssExtractPlugin.loader,
          "css-loader",
          "resolve-url-loader",
          "sass-loader",
        ],
      },
      {
        test: /\.css$/i,
        use: [
          MiniCssExtractPlugin.loader,
          "css-loader",
          {
            loader: "sass-loader",
            options: {
              sassOptions: { indentedSyntax: true },
            },
          },
        ],
      },
      {
        test: /\.(png|jpe?g|gif|svg|webp)$/i,
        type: "asset",
        parser: {
          dataUrlCondition: {
            maxSize: 8192,
          },
        },
        generator: {
          filename: "images/[name][ext][query]",
        },
      },
      {
        test: /\.(woff2?|ttf|eot)(\?v=\w+)?$/,
        type: "asset/resource",
        generator: {
          filename: "fonts/[name][ext][query]",
        },
      },
    ],
  },
  stats: {
    children: true,
  },
};
