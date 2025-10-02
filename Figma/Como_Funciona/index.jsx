import React from "react";
import ASSAPMo1 from "./ASSAP-MO-1.png";
import { CardBenefit } from "./CardBenefit";
import { CardBenefitInstanceWrapper } from "./CardBenefitInstanceWrapper";
import { CardBenefitWrapper } from "./CardBenefitWrapper";
import { ContentHeading } from "./ContentHeading";
import { Footer } from "./Footer";
import { MenuBookWrapper } from "./MenuBookWrapper";
import estrellaB1 from "./estrella-b-1.png";
import image2 from "./image-2.png";
import image from "./image.png";
import rayoB1 from "./rayo-b-1.png";
import "./style.css";
import torreB1 from "./torre-b-1.png";
import vector1 from "./vector-1.svg";
import vector2 from "./vector-2.svg";

export const ComoFunciona = () => {
  return (
    <div className="como-funciona">
      <div className="rectangle-3" />

      <div className="rectangle-4" />

      <img className="ASSAP-MO" alt="Assap MO" src={ASSAPMo1} />

      <div className="text-wrapper-24">Ajustes</div>

      <MenuBookWrapper />
      <img className="vector" alt="Vector" src={vector1} />

      <img className="vector-2" alt="Vector" src={vector2} />

      <div className="nav-list">
        <div className="link">
          <div className="text-wrapper-25">Inicio</div>

          <div className="rectangle-5" />
        </div>

        <div className="text-wrapper-26">Como Funciona</div>

        <div className="link-2">
          <div className="text-wrapper-27">Factura</div>
        </div>

        <div className="link-2">
          <div className="text-wrapper-27">Base De Datos</div>
        </div>

        <div className="link-wrapper">
          <div className="link-2">
            <div className="mi-cuenta">Mi Cuenta</div>
          </div>
        </div>
      </div>

      <ContentHeading />
      <CardBenefit />
      <CardBenefitWrapper />
      <CardBenefitInstanceWrapper />
      <img className="estrella-b" alt="Estrella b" src={estrellaB1} />

      <img className="torre-b" alt="Torre b" src={torreB1} />

      <img className="rayo-b" alt="Rayo b" src={rayoB1} />

      <img className="LOGO-a-2" alt="Logo a" src={image} />

      <div className="text-wrapper-28"></div>

      <img className="image" alt="Image" src={image2} />

      <Footer />
    </div>
  );
};
