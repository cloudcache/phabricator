<?php

final class PhabricatorFileLinkView extends AphrontView {

  private $fileName;
  private $fileDownloadURI;
  private $fileViewURI;
  private $fileViewable;
  private $filePHID;
  private $fileMonogram;
  private $fileSize;
  private $customClass;

  public function setCustomClass($custom_class) {
    $this->customClass = $custom_class;
    return $this;
  }

  public function getCustomClass() {
    return $this->customClass;
  }

  public function setFilePHID($file_phid) {
    $this->filePHID = $file_phid;
    return $this;
  }

  private function getFilePHID() {
    return $this->filePHID;
  }

  public function setFileMonogram($monogram) {
    $this->fileMonogram = $monogram;
    return $this;
  }

  private function getFileMonogram() {
    return $this->fileMonogram;
  }

  public function setFileViewable($file_viewable) {
    $this->fileViewable = $file_viewable;
    return $this;
  }

  private function getFileViewable() {
    return $this->fileViewable;
  }

  public function setFileViewURI($file_view_uri) {
    $this->fileViewURI = $file_view_uri;
    return $this;
  }

  private function getFileViewURI() {
    return $this->fileViewURI;
  }

  public function setFileDownloadURI($file_download_uri) {
    $this->fileDownloadURI = $file_download_uri;
    return $this;
  }

  private function getFileDownloadURI() {
    return $this->fileDownloadURI;
  }

  public function setFileName($file_name) {
    $this->fileName = $file_name;
    return $this;
  }

  private function getFileName() {
    return $this->fileName;
  }

  public function setFileSize($file_size) {
    $this->fileSize = $file_size;
    return $this;
  }

  private function getFileSize() {
    return $this->fileSize;
  }

  private function getFileIcon() {
    return FileTypeIcon::getFileIcon($this->getFileName());
  }

  public function getMetadata() {
    return array(
      'phid'     => $this->getFilePHID(),
      'viewable' => $this->getFileViewable(),
      'uri'      => $this->getFileViewURI(),
      'dUri'     => $this->getFileDownloadURI(),
      'name'     => $this->getFileName(),
      'monogram' => $this->getFileMonogram(),
      'icon'     => $this->getFileIcon(),
      'size'     => $this->getFileSize(),
    );
  }

  public function render() {
    require_celerity_resource('phabricator-remarkup-css');
    require_celerity_resource('phui-lightbox-css');

    $mustcapture = true;
    $sigil = 'lightboxable';
    $meta = $this->getMetadata();

    $class = 'phabricator-remarkup-embed-layout-link';
    if ($this->getCustomClass()) {
      $class = $this->getCustomClass();
    }

    $icon = id(new PHUIIconView())
      ->setIcon($this->getFileIcon());

    $info = phutil_tag(
      'span',
      array(
        'class' => 'phabricator-remarkup-embed-layout-info',
      ),
      $this->getFileSize());

    $name = phutil_tag(
      'span',
      array(
        'class' => 'phabricator-remarkup-embed-layout-name',
      ),
      $this->getFileName());

    $inner = phutil_tag(
      'span',
      array(
        'class' => 'phabricator-remarkup-embed-layout-info-block',
      ),
      array(
        $name,
        $info,
      ));

    return javelin_tag(
      'a',
      array(
        'href'        => $this->getFileViewURI(),
        'class'       => $class,
        'sigil'       => $sigil,
        'meta'        => $meta,
        'mustcapture' => $mustcapture,
      ),
      array(
        $icon,
        $inner,
      ));
  }
}
