import { useState, useEffect } from 'react'
import { Container, Col, Row, Button } from 'react-bootstrap'
import Header from '../Header'
import { useNavigate, useParams } from 'react-router-dom'
import BerhasilMengambilDaftarComment from '../../core/Responses/ResponseBerhasil/Comment/BerhasilMengambilDaftarComment'
import Comment from '../../core/Comment/Data/Comment'
import RequestAmbilInformasiSoal from '../../core/Soal/RequestAmbilInformasiSoal'
import BerhasilAmbilInformasiSoal from '../../core/Responses/ResponseBerhasil/Soal/BerhasilAmbilInformasiSoal'
import RequestDaftarComment from '../../core/Comment/RequestDaftarComment'
import RequestKirimComment from '../../core/Comment/RequestKirimComment'
import BerhasilMengirimComment from '../../core/Responses/ResponseBerhasil/Comment/BerhasilMengirimComment'
import RequestHapusComment from '../../core/Comment/RequestHapusComment'
import HapusComment from '../../core/Comment/Data/HapusComment'
import BerhasilMenghapusComment from '../../core/Responses/ResponseBerhasil/Comment/BerhasilMenghapusComment'

function HalamanDiskusi() {

  const navigate = useNavigate()
  const parameterURL = useParams()

  const pindahHalamanPengerjaan = () => {
    navigate(`/soal/${parameterURL.id_soal}/pengerjaan`)
  }

  const pindahHalamanHasil = () => {
    navigate(`/soal/${parameterURL.id_soal}/hasil`)
  }

  const [daftarKomentar, setDaftarKomentar] = useState<BerhasilMengambilDaftarComment[]>([])
  const [komentar, setKomentar] = useState<Comment>({id_ruangan : "", isi : "", reply : null} as Comment)

  const requestAmbilInformasiSoal : RequestAmbilInformasiSoal = new RequestAmbilInformasiSoal();
  const requestDaftarComment : RequestDaftarComment = new RequestDaftarComment()
  const requestKirimComment : RequestKirimComment = new RequestKirimComment()
  const requestHapusComment : RequestHapusComment = new RequestHapusComment()

  useEffect(() => {
    if (parameterURL.id_soal == undefined) {
      pindahHalamanPengerjaan() 
    }

    requestAmbilInformasiSoal.execute(parameterURL.id_soal != undefined ? parameterURL.id_soal : "", (hasil : any) => {
      if (hasil instanceof BerhasilAmbilInformasiSoal) {
        setKomentar({...komentar, id_ruangan : hasil.id_ruangan_diskusi})
        requestDaftarComment.execute(hasil.id_ruangan_diskusi, (hasil : any) => {
          if (Array.isArray(hasil)) {
            setDaftarKomentar(hasil)
          }
          else {
            window.location.reload();
          }
        })
      }
      else {
        pindahHalamanPengerjaan()
      }
    })

    function loadScriptCKEditor() {
      return new Promise((resolve, reject) => {
        if (document.getElementById("ckeditor") == null) {
          const script = document.createElement('script');
          script.src = "/ckeditor5-38.0.1/build/ckeditor.js";
          script.onload = resolve;
          script.onerror = reject;
          script.id = "ckeditor"
          document.body.appendChild(script);
        }
        else {
          resolve(true)
        }
      });
    }
    function loadScriptCustomCKEditor() {
      return new Promise((resolve, reject) => {
        if (document.getElementById("ckeditor-custom-build") == null) {
          const script = document.createElement('script');
          script.innerHTML = `
            let ckEditor = null
            
            ClassicEditor.create( '', {
                licenseKey: '',
            })
            .then( editor => {
                window.editor_comment = editor;
                editor.model.document.on('change:data', () => {
                  window.perubahanCKEditor(editor.getData())
                })
                document.getElementById("editor").appendChild(editor.ui.element)
            })
            .catch( error => {
                console.error( 'Oops, something went wrong!' );
                console.error( 'Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:' );
                console.warn( 'Build id: n96xuuc5ag4v-nk96buq2xi5g' );
                console.error( error );
            })`;
          script.onload = resolve;
          script.onerror = reject;
          script.id = "ckeditor-custom-build"
          document.body.appendChild(script);
        }
        else {
          resolve(true)
          document.getElementById("editor")?.appendChild((window as any).editor_comment.ui.element)
        }
      });
    }

    async function loadCKEditor() {
      await loadScriptCKEditor()
      await loadScriptCustomCKEditor()

      document.getElementById("editor")?.append((window as any).editor_comment.ui.element)
    }

    return () => {
      loadCKEditor()
    };

  }, [])

  const submitComment = () => {
    if (komentar.id_ruangan != "") {
      requestKirimComment.execute(komentar, (hasil : any) => {
        if (hasil instanceof BerhasilMengirimComment) {
          (window as any).editor_comment.setData("")
          window.location.reload()
        }
      })
    }
  }

  const hapusComment = (idComment : string) => {
    requestHapusComment.execute({id_comment : idComment, id_ruangan : komentar.id_ruangan} as HapusComment,  (hasil : any) => {
      if (hasil instanceof BerhasilMenghapusComment) {
        window.location.reload()
      }
    })
  }

  function perubahanCKEditor(isiKomentar : string) {
    setKomentar({...komentar, isi : isiKomentar})
  }
  (window as any).perubahanCKEditor = perubahanCKEditor

  return (
  <>
    <Container className='min-vh-100 mw-100 w-100 m-0 p-0 d-flex flex-column'>
      <Header />
      <Row className='m-0 mb-2 p-0 d-flex flex-row justify-content-start'>
        <Col className='m-0 p-0 d-flex flex-row justify-content-center' xs={1}>
          <Button variant='light' className='m-0 w-100 rounded-0 text-center' onClick={pindahHalamanPengerjaan}>
            Pengerjaan
          </Button>
        </Col>
        <Col className='m-0 p-0 d-flex flex-row justify-content-center' xs={1}>
          <Button variant='dark' className='m-0 w-100 rounded-0 text-center'>
            Diskusi
          </Button>
        </Col>
        <Col className='m-0 p-0 d-flex flex-row justify-content-center' xs={1} onClick={pindahHalamanHasil}>
          <Button variant='light' className='m-0 w-100 rounded-0 text-center'>
            Submission
          </Button>
        </Col>
        <hr className='m-0 p-0'></hr>
      </Row>
      <Col xs={12} className='m-0 p-0 d-flex justify-content-center'>
        <Col xs={12} sm={12} md={8} lg={6} xl={6} className='m-0 p-0'>
          <Row className="m-0 p-0 d-flex flex-column">
            <Row className="m-0 p-0 d-flex flex-column">
              {daftarKomentar.map((comen : BerhasilMengambilDaftarComment, index : number) => {

                let balasan : number = -1
                if (comen.reply != null) {
                  balasan = daftarKomentar.findIndex((c) => c.id_comment === comen.reply)
                }

                return (
                  <section id={`k-${index}`} className='m-0 pb-3' key={comen.id_comment}>
                    <Row className='m-0 py-1 d-flex flex-column'>
                      <p className="m-0 py-1 fs-6 text-start border border-dark">{comen.nama_penulis}</p>
                      {
                        balasan != -1 &&
                        <a className='m-0 py-1 fs-6 text-dark bg-secondary text-decoration-none border border-dark' href={`#k-${balasan}`}>
                          <blockquote className='m-0 py-1 blockquote fs-6 text-truncate'>
                            <p className='text-truncate' dangerouslySetInnerHTML={{ __html: daftarKomentar[balasan].isi}} style={{"wordWrap" : 'break-word'}}>
                            </p>
                          </blockquote>
                        </a>
                      }
                      <Col xs={12} dangerouslySetInnerHTML={{ __html: comen.isi}} className='border border-dark'></Col>
                      <a href='#kolom-komentar' onClick={() => {
                        setKomentar({...komentar, reply: comen.id_comment})
                      }}>Balas</a>
                      {
                        (comen.id_penulis == localStorage.getItem("id") || 'admin' == localStorage.getItem("role")) &&
                        <a href='#kolom-komentar' onClick={() => {
                          hapusComment(comen.id_comment)
                        }}>Hapus</a>
                      }
                    </Row>
                  </section>
                )
              })}
            </Row>
            <Col className='m-0 my-3 p-0'>
              <section id="kolom-komentar" className='m-0 p-0'>
                <Row className='m-0 p-0 d-flex flex-row'>
                  <Col xs={9} className='m-0 p-0 px-2'>
                      {
                        komentar.reply != null &&
                        <Row className='m-0 p-0 d-flex flex-row'>
                          <Col xs={10} className='m-0 p-0'>
                            <blockquote className='blockquote fs-6'>
                              <p className='text-truncate' dangerouslySetInnerHTML={{ __html: daftarKomentar.find((c) => c.id_comment === komentar.reply)!.isi}}>
                              </p>
                            </blockquote>
                          </Col>
                          <Col xs={2} className='m-0 p-0 d-flex flex-column'>
                            <Button variant='light' className='rounded-0 border border-dark' onClick={() => {
                        setKomentar({...komentar, reply: null})
                            }}>
                              X
                            </Button>
                          </Col>
                        </Row>
                      }
                      <div id="editor">
                      </div>
                  </Col>
                  <Col xs={3} className='m-0 p-0 px-2'>
                    <Button variant='dark' className='px-3 rounded-pill' onClick={submitComment}>
                      Kirim
                    </Button>
                  </Col>
                </Row>
              </section>
            </Col>
          </Row>
        </Col>
      </Col>
    </Container>
  </>)
}

export default HalamanDiskusi
